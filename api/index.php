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
    '/tmp/views',
    '/tmp/sessions',
    '/tmp/cache',
    '/tmp/logs',
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
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

// 3. Prepare SQLite database in /tmp
$sourceDb = __DIR__ . '/../database/database.sqlite';
$targetDb = '/tmp/database.sqlite';

if (file_exists($sourceDb) && (!file_exists($targetDb) || filesize($targetDb) === 0)) {
    @copy($sourceDb, $targetDb);
} elseif (!file_exists($targetDb)) {
    @touch($targetDb);
}

if (empty(getenv('DB_CONNECTION')) || getenv('DB_CONNECTION') === 'sqlite') {
    putenv('DB_CONNECTION=sqlite');
    putenv("DB_DATABASE={$targetDb}");
    $_ENV['DB_CONNECTION'] = 'sqlite';
    $_ENV['DB_DATABASE'] = $targetDb;
}

// 4. Forward execution to Laravel's public index
require __DIR__ . '/../public/index.php';
