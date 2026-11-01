<?php

declare(strict_types=1);

/**
 * Application Configuration
 */

define('APP_NAME', 'OrgSync');
define('APP_TAGLINE', 'Plan. Collaborate. Achieve.');

/**
 * Database Credentials
 * Automatically switches between Localhost and InfinityFree
 */
$isLocal = in_array(
    strtolower(explode(':', $_SERVER['HTTP_HOST'] ?? 'localhost')[0]),
    ['localhost', '127.0.0.1', '::1'],
    true
);

if ($isLocal) {
    define('DB_HOST', 'localhost');
    define('DB_PORT', '3306');
    define('DB_NAME', 'orgsync_db');
    define('DB_USER', 'root');
    define('DB_PASS', '');
} else {
    // infinityfree
    define('DB_HOST', 'sql213.infinityfree.com');
    define('DB_PORT', '3306');
    define('DB_NAME', 'if0_43276925_orgsync');
    define('DB_USER', 'if0_43276925');
    define('DB_PASS', 'Frank512357864');
}

/**
 * Resolve base URL dynamically to support both root web servers and subdirectories
 */
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$requestUri = $_SERVER['REQUEST_URI'] ?? '';

if (str_ends_with($scriptDir, '/public') && !str_contains($requestUri, '/public')) {
    $parentDir = dirname($scriptDir);
    $basePath = ($parentDir === '/' || $parentDir === '\\' || $parentDir === '.') ? '' : rtrim(str_replace('\\', '/', $parentDir), '/');
} else {
    $basePath = rtrim($scriptDir, '/');
}

define('BASE_URL', $scheme . '://' . $host . ($basePath === '' ? '' : $basePath));
define('ROOT_PATH', dirname(__DIR__, 2));
define('APP_PATH', dirname(__DIR__));
define('PUBLIC_PATH', ROOT_PATH . '/public');
