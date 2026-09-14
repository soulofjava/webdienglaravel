<?php

/**
 * Entry point serverless untuk runtime Vercel PHP.
 * Meneruskan request dari Vercel ke front-controller Laravel.
 */

// Siapkan direktori writable ephemeral di lingkungan Vercel Serverless
foreach (['/tmp/views', '/tmp/storage/framework/views', '/tmp/storage/framework/cache', '/tmp/storage/framework/sessions', '/tmp/storage/logs'] as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

require __DIR__ . '/../public/index.php';
