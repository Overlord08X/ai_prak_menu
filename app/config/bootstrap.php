<?php
declare(strict_types=1);

$config = require __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../helpers.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name($config['session_name']);
    session_start();
}

spl_autoload_register(static function (string $class): void {
    $directories = [
        __DIR__ . '/../core/',
        __DIR__ . '/../models/',
        __DIR__ . '/../services/',
        __DIR__ . '/../controllers/',
    ];

    foreach ($directories as $directory) {
        $path = $directory . $class . '.php';
        if (is_file($path)) {
            require_once $path;
            return;
        }
    }
});
