<?php

/**
 * Vercel Serverless Entrypoint for Laravel
 */

// Create necessary temporary directories in /tmp for serverless environment
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

// Copy default SQLite DB to /tmp if present, to allow read/write in serverless
$sourceDb = __DIR__ . '/../database/database.sqlite';
$targetDb = '/tmp/database.sqlite';
if (file_exists($sourceDb) && !file_exists($targetDb)) {
    @copy($sourceDb, $targetDb);
}

// Forward execution to Laravel's public entrypoint
require __DIR__ . '/../public/index.php';
