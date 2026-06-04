<?php
declare(strict_types=1);

class UserController extends BaseController
{
    public function __construct(private readonly UserModel $userModel = new UserModel())
    {
    }

    public function index(): void
    {
        $this->requireAdmin();
        $this->render('admin/users/index', [
            'title' => 'Data User',
            'users' => $this->userModel->allWithCounts(),
        ], 'admin');
    }

    public function create(): void
    {
        $this->requireAdmin();
        $this->render('admin/users/form', [
            'title' => 'Tambah User',
            'user' => null,
            'action' => 'user/store',
        ], 'admin');
    }

    public function store(): void
    {
        $this->requireAdmin();
        $nama = trim((string) ($_POST['nama'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $role = (string) ($_POST['role'] ?? 'user');

        if ($nama === '' || $email === '' || $password === '') {
            flash('error', 'Semua field wajib diisi.');
            set_old($_POST);
            redirect('user/create');
        }

        if ($this->userModel->findByEmail($email)) {
            flash('error', 'Email sudah terdaftar.');
            set_old($_POST);
            redirect('user/create');
        }

        $this->userModel->create([
            'nama' => $nama,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => in_array($role, ['admin', 'user'], true) ? $role : 'user',
        ]);

        clear_old();
        flash('success', 'User berhasil ditambahkan.');
        redirect('user/index');
    }

    public function edit(): void
    {
        $this->requireAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        $user = $this->userModel->find($id);
        if (!$user) {
            flash('error', 'User tidak ditemukan.');
            redirect('user/index');
        }

        $this->render('admin/users/form', [
            'title' => 'Edit User',
            'user' => $user,
            'action' => 'user/update&id=' . $id,
        ], 'admin');
    }

    public function update(): void
    {
        $this->requireAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        $nama = trim((string) ($_POST['nama'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $role = (string) ($_POST['role'] ?? 'user');

        if ($nama === '' || $email === '') {
            flash('error', 'Nama dan email wajib diisi.');
            set_old($_POST);
            redirect('user/edit&id=' . $id);
        }

        $this->userModel->updateUser($id, [
            'nama' => $nama,
            'email' => $email,
            'password' => $password !== '' ? password_hash($password, PASSWORD_DEFAULT) : '',
            'role' => in_array($role, ['admin', 'user'], true) ? $role : 'user',
        ]);

        clear_old();
        flash('success', 'User berhasil diperbarui.');
        redirect('user/index');
    }

    public function delete(): void
    {
        $this->requireAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        if (auth_user() && (int) auth_user()['id'] === $id) {
            flash('error', 'Akun aktif tidak bisa dihapus.');
            redirect('user/index');
        }

        $this->userModel->delete($id);
        flash('success', 'User berhasil dihapus.');
        redirect('user/index');
    }
}
