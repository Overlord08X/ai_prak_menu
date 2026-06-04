<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/config/bootstrap.php';

$route = $_GET['route'] ?? '';

if ($route === '') {
    if (auth_role('admin')) {
        redirect('dashboard/admin');
    }

    if (auth_check()) {
        redirect('dashboard/user');
    }

    redirect('auth/login');
}

[$controllerSegment, $action] = array_pad(explode('/', $route, 2), 2, 'index');
$controllerName = ucfirst(strtolower($controllerSegment)) . 'Controller';

if (!class_exists($controllerName)) {
    http_response_code(404);
    exit('Controller not found');
}

$controller = new $controllerName();
$action = $action ?: 'index';

if (!method_exists($controller, $action)) {
    http_response_code(404);
    exit('Action not found');
}

verify_csrf();
$controller->{$action}();
