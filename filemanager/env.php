<?php
/**
 * Minimal .env loader — no dependencies required.
 * Parses KEY=VALUE lines from .env into $_ENV and getenv().
 */
function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') {
            continue;
        }
        $pos = strpos($line, '=');
        if ($pos === false) {
            continue;
        }
        $key = trim(substr($line, 0, $pos));
        $val = trim(substr($line, $pos + 1));
        // Remove surrounding quotes if present
        if (strlen($val) >= 2 && $val[0] === '"' && $val[strlen($val) - 1] === '"') {
            $val = substr($val, 1, -1);
        }
        $_ENV[$key] = $val;
        // putenv disabled on this host
        if (function_exists("putenv")) { putenv("$key=$val"); }
    }
}

loadEnv(dirname(__DIR__) . '/.env');
