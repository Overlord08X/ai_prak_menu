<?php
declare(strict_types=1);

class BaseController
{
    protected function render(string $view, array $data = [], string $layout = 'user'): void
    {
        extract($data);

        ob_start();
        $viewFile = __DIR__ . '/../../views/' . $view . '.php';
        if (!is_file($viewFile)) {
            throw new RuntimeException('View not found: ' . $view);
        }
        require $viewFile;
        $content = ob_get_clean();

        $layoutFile = __DIR__ . '/../../views/layouts/' . $layout . '.php';
        require $layoutFile;
    }

    protected function requireLogin(): void
    {
        if (!auth_check()) {
            flash('error', 'Silakan login terlebih dahulu.');
            redirect('auth/login');
        }
    }

    protected function requireAdmin(): void
    {
        $this->requireLogin();
        if (!auth_role('admin')) {
            flash('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('dashboard/user');
        }
    }
}
