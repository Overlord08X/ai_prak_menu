<?php
/**
 * Router untuk PHP Built-in Server
 * Melayani static files langsung, request lain ke index.php
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Jika file static (css, js, gambar, dll) benar-benar ada, sajikan langsung
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false; // PHP built-in server akan serve file tersebut
}

// Semua request lainnya → index.php
require_once __DIR__ . '/index.php';
