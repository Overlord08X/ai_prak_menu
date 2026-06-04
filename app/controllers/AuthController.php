<?php
declare(strict_types=1);

class AuthController extends BaseController
{
    public function __construct(private readonly UserModel $userModel = new UserModel())
    {
    }

    public function login(): void
    {
        if (auth_check()) {
            redirect(auth_role('admin') ? 'dashboard/admin' : 'dashboard/user');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim((string) ($_POST['email'] ?? ''));
            $password = (string) ($_POST['password'] ?? '');

            if ($email === '' || $password === '') {
                flash('error', 'Email dan password wajib diisi.');
                set_old($_POST);
            } else {
                $user = $this->userModel->findByEmail($email);
                $storedPassword = $user['password'] ?? '';
                $validPassword = $user && (
                    password_verify($password, $storedPassword) ||
                    hash_equals(hash('sha256', $password), (string) $storedPassword) ||
                    hash_equals($password, (string) $storedPassword)
                );

                if ($validPassword) {
                    $_SESSION['auth_user'] = [
                        'id' => (int) $user['id'],
                        'nama' => $user['nama'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                    ];
                    clear_old();
                    flash('success', 'Login berhasil.');
                    redirect($user['role'] === 'admin' ? 'dashboard/admin' : 'dashboard/user');
                }

                flash('error', 'Email atau password salah.');
                set_old($_POST);
            }
        }

        $this->render('auth/login', ['title' => 'Login'], 'auth');
    }

    public function register(): void
    {
        if (auth_check()) {
            redirect(auth_role('admin') ? 'dashboard/admin' : 'dashboard/user');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim((string) ($_POST['nama'] ?? ''));
            $email = trim((string) ($_POST['email'] ?? ''));
            $password = (string) ($_POST['password'] ?? '');
            $confirm = (string) ($_POST['password_confirmation'] ?? '');

            if ($nama === '' || $email === '' || $password === '') {
                flash('error', 'Semua field wajib diisi.');
                set_old($_POST);
            } elseif ($password !== $confirm) {
                flash('error', 'Konfirmasi password tidak sama.');
                set_old($_POST);
            } elseif ($this->userModel->findByEmail($email)) {
                flash('error', 'Email sudah terdaftar.');
                set_old($_POST);
            } else {
                $this->userModel->create([
                    'nama' => $nama,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => 'user',
                ]);

                clear_old();
                flash('success', 'Registrasi berhasil. Silakan login.');
                redirect('auth/login');
            }
        }

        $this->render('auth/register', ['title' => 'Register'], 'auth');
    }

    public function logout(): void
    {
        session_destroy();
        session_start();
        flash('success', 'Anda telah logout.');
        redirect('auth/login');
    }
}
