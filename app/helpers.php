<?php
declare(strict_types=1);

function config(string $key, mixed $default = null): mixed
{
    global $config;
    return $config[$key] ?? $default;
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function route_url(string $route = ''): string
{
    if ($route === '') {
        return '/index.php';
    }

    return '/index.php?route=' . $route;
}

function asset_url(string $path): string
{
    // Gunakan root-relative URL agar tidak bergantung pada APP_URL
    return '/' . ltrim($path, '/');
}

function redirect(string $route): never
{
    header('Location: ' . route_url($route));
    exit;
}

function old(string $key, mixed $default = ''): mixed
{
    return $_SESSION['_old'][$key] ?? $default;
}

function set_old(array $data): void
{
    $_SESSION['_old'] = $data;
}

function clear_old(): void
{
    unset($_SESSION['_old']);
}

function flash(string $key, ?string $message = null): mixed
{
    if ($message !== null) {
        $_SESSION['_flash'][$key] = $message;
        return null;
    }

    if (!isset($_SESSION['_flash'][$key])) {
        return null;
    }

    $value = $_SESSION['_flash'][$key];
    unset($_SESSION['_flash'][$key]);
    return $value;
}

function auth_user(): ?array
{
    return $_SESSION['auth_user'] ?? null;
}

function auth_check(): bool
{
    return isset($_SESSION['auth_user']);
}

function auth_role(?string $role = null): bool
{
    if (!auth_check()) {
        return false;
    }

    if ($role === null) {
        return true;
    }

    return ($_SESSION['auth_user']['role'] ?? '') === $role;
}

function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['_csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['_csrf'] ?? '';
        if (!hash_equals(csrf_token(), (string) $token)) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
    }
}

function selected(array $values, mixed $value): string
{
    return in_array((string) $value, array_map('strval', $values), true) ? 'selected' : '';
}

function checked(array $values, mixed $value): string
{
    return in_array((string) $value, array_map('strval', $values), true) ? 'checked' : '';
}

function format_date(?string $date): string
{
    if (!$date) {
        return '-';
    }

    $timestamp = strtotime($date);
    return $timestamp ? date('d M Y H:i', $timestamp) : $date;
}

function upload_image(?array $file, ?string $oldFile = null): ?string
{
    if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return $oldFile;
    }

    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        return $oldFile;
    }

    $allowed = ['image/jpeg', 'image/png', 'image/webp'];
    $mime = mime_content_type($file['tmp_name']);
    if (!in_array($mime, $allowed, true)) {
        return $oldFile;
    }

    $extension = match ($mime) {
        'image/png' => 'png',
        'image/webp' => 'webp',
        default => 'jpg',
    };

    $directory = config('upload_dir');
    if (!is_dir($directory)) {
        mkdir($directory, 0775, true);
    }

    $filename = bin2hex(random_bytes(12)) . '.' . $extension;
    $target = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;

    if (move_uploaded_file($file['tmp_name'], $target)) {
        if ($oldFile && is_file($directory . DIRECTORY_SEPARATOR . basename($oldFile))) {
            @unlink($directory . DIRECTORY_SEPARATOR . basename($oldFile));
        }
        return config('upload_url') . '/' . $filename;
    }

    return $oldFile;
}
