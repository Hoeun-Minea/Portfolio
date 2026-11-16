<?php

/**
 * Vercel Serverless Entrypoint for Laravel
 */

// 1. Prepare writable directories in /tmp for serverless environment
$tmpDirs = [
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

// 2. Fallback APP_KEY if missing in Vercel Environment Variables
if (empty(getenv('APP_KEY'))) {
    $fallbackKey = 'base64:c5L2Q9Wqj36eA9J3Z4+D3e8q1yQ3a6K5d8L9n0M1p4Q=';
    putenv("APP_KEY={$fallbackKey}");
    $_ENV['APP_KEY'] = $fallbackKey;
}

// 3. Fallback SQLite database in /tmp if external MySQL is not yet configured
if (empty(getenv('DB_CONNECTION')) || getenv('DB_CONNECTION') === 'sqlite') {
    $dbPath = '/tmp/database.sqlite';
    if (!file_exists($dbPath)) {
        @touch($dbPath);
    }
    putenv('DB_CONNECTION=sqlite');
    putenv("DB_DATABASE={$dbPath}");
    $_ENV['DB_CONNECTION'] = 'sqlite';
    $_ENV['DB_DATABASE'] = $dbPath;
}

// 4. Forward execution to Laravel's public index
require __DIR__ . '/../public/index.php';
