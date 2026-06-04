<?php
declare(strict_types=1);

return [
    'app_name' => 'Craft Food Finder',
    'app_url' => rtrim((string) (getenv('APP_URL') ?: 'http://localhost:8080'), '/'),
    'session_name' => 'craft_food_finder_session',
    'db_host' => getenv('DB_HOST') ?: 'mysql',
    'db_port' => getenv('DB_PORT') ?: '3306',
    'db_name' => getenv('DB_DATABASE') ?: 'craft_food_finder',
    'db_user' => getenv('DB_USERNAME') ?: 'root',
    'db_pass' => getenv('DB_PASSWORD') ?: 'secret',
    'db_charset' => 'utf8mb4',
    'upload_dir' => __DIR__ . '/../../public/assets/uploads',
    'upload_url' => '/assets/uploads',
];
