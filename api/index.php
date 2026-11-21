<?php

/**
 * Vercel Serverless Entrypoint for Laravel
 */

// 1. Prepare writable directories in /tmp for serverless environment
$tmpDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/storage/app/public',
    '/tmp/storage/app/public/documents',
    '/tmp/views',
    '/tmp/sessions',
    '/tmp/cache',
    '/tmp/logs',
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// 2. Set essential serverless environment variables
putenv('VERCEL=1');
$_ENV['VERCEL'] = '1';

if (empty(getenv('APP_KEY'))) {
    $fallbackKey = 'base64:c5L2Q9Wqj36eA9J3Z4+D3e8q1yQ3a6K5d8L9n0M1p4Q=';
    putenv("APP_KEY={$fallbackKey}");
    $_ENV['APP_KEY'] = $fallbackKey;
}

putenv('CACHE_STORE=array');
putenv('CACHE_DRIVER=array');
$_ENV['CACHE_STORE'] = 'array';
$_ENV['CACHE_DRIVER'] = 'array';

putenv('SESSION_DRIVER=cookie');
$_ENV['SESSION_DRIVER'] = 'cookie';

putenv('VIEW_COMPILED_PATH=/tmp/views');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';

// 3. Prepare SQLite database in /tmp (ការពារកុំឱ្យបាត់ឯកសារពេល Update ប្រព័ន្ធ)
$sourceDb = __DIR__ . '/../database/database.sqlite';
$targetDb = '/tmp/database.sqlite';

$targetHasDocs = false;
if (file_exists($targetDb) && filesize($targetDb) > 0) {
    try {
        $pdoCheck = new PDO("sqlite:$targetDb");
        $stmtCheck = $pdoCheck->query("SELECT count(*) FROM documents");
        if ($stmtCheck && (int)$stmtCheck->fetchColumn() > 0) {
            $targetHasDocs = true; // មានឯកសារ Upload រួចហើយ មិនត្រូវ Overwrite ឡើយ
        }
    } catch (\Throwable $e) {}
}

if (!$targetHasDocs && file_exists($sourceDb)) {
    if (!file_exists($targetDb) || filesize($targetDb) === 0 || filemtime($sourceDb) > filemtime($targetDb)) {
        @copy($sourceDb, $targetDb);
        @chmod($targetDb, 0666);
    }
} elseif (!file_exists($targetDb)) {
    @touch($targetDb);
    @chmod($targetDb, 0666);
}

// ធានាថារាល់ Column សំខាន់ៗ (views_count, downloads_count, file_data) មានជានិច្ច
if (file_exists($targetDb) && filesize($targetDb) > 0) {
    try {
        $pdo = new PDO("sqlite:$targetDb");
        $cols = [];
        $res = $pdo->query("PRAGMA table_info(documents)");
        if ($res) {
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $cols[] = $row['name'];
            }
            if (!in_array('views_count', $cols)) {
                $pdo->exec("ALTER TABLE documents ADD COLUMN views_count INTEGER DEFAULT 0");
            }
            if (!in_array('downloads_count', $cols)) {
                $pdo->exec("ALTER TABLE documents ADD COLUMN downloads_count INTEGER DEFAULT 0");
            }
            if (!in_array('file_data', $cols)) {
                $pdo->exec("ALTER TABLE documents ADD COLUMN file_data LONGTEXT NULL");
            }
        }
    } catch (\Throwable $e) {}
}

if (empty(getenv('DB_CONNECTION')) || getenv('DB_CONNECTION') === 'sqlite') {
    putenv('DB_CONNECTION=sqlite');
    putenv("DB_DATABASE={$targetDb}");
    $_ENV['DB_CONNECTION'] = 'sqlite';
    $_ENV['DB_DATABASE'] = $targetDb;
}

// 4. Copy bundled documents to /tmp/storage/app/public/documents if missing
$sourceDocs = __DIR__ . '/../storage/app/public/documents';
$targetDocs = '/tmp/storage/app/public/documents';
if (is_dir($sourceDocs)) {
    $files = scandir($sourceDocs);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $srcFile = $sourceDocs . '/' . $file;
            $dstFile = $targetDocs . '/' . $file;
            if (!file_exists($dstFile) && is_file($srcFile)) {
                @copy($srcFile, $dstFile);
                @chmod($dstFile, 0666);
            }
        }
    }
}

// 5. Forward execution to Laravel's public index
require __DIR__ . '/../public/index.php';
