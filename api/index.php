<?php

/**
 * Entry point serverless untuk runtime Vercel PHP.
 * Meneruskan request dari Vercel ke front-controller Laravel.
 */

// Normalisasi SCRIPT_NAME & SCRIPT_FILENAME agar Laravel tidak menganggap /api sebagai base-path
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/../public/index.php';

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

// Siapkan direktori writable ephemeral di lingkungan Vercel Serverless
foreach (['/tmp/views', '/tmp/storage/framework/views', '/tmp/storage/framework/cache', '/tmp/storage/framework/sessions', '/tmp/storage/logs'] as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

require __DIR__ . '/../public/index.php';
