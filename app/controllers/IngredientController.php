<?php
declare(strict_types=1);

class IngredientController extends BaseController
{
    public function __construct(private readonly IngredientModel $ingredientModel = new IngredientModel())
    {
    }

    public function index(): void
    {
        $this->requireAdmin();
        $this->render('admin/ingredients/index', [
            'title' => 'Data Bahan',
            'ingredients' => $this->ingredientModel->allWithUsage(),
        ], 'admin');
    }

    public function create(): void
    {
        $this->requireAdmin();
        $this->render('admin/ingredients/form', [
            'title' => 'Tambah Bahan',
            'ingredient' => null,
            'action' => 'ingredient/store',
        ], 'admin');
    }

    public function store(): void
    {
        $this->requireAdmin();
        $nama = trim((string) ($_POST['nama_bahan'] ?? ''));
        $deskripsi = trim((string) ($_POST['deskripsi'] ?? ''));

        if ($nama === '') {
            flash('error', 'Nama bahan wajib diisi.');
            set_old($_POST);
            redirect('ingredient/create');
        }

        $this->ingredientModel->create([
            'nama_bahan' => $nama,
            'deskripsi' => $deskripsi,
        ]);

        clear_old();
        flash('success', 'Bahan berhasil ditambahkan.');
        redirect('ingredient/index');
    }

    public function edit(): void
    {
        $this->requireAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        $ingredient = $this->ingredientModel->find($id);
        if (!$ingredient) {
            flash('error', 'Bahan tidak ditemukan.');
            redirect('ingredient/index');
        }

        $this->render('admin/ingredients/form', [
            'title' => 'Edit Bahan',
            'ingredient' => $ingredient,
            'action' => 'ingredient/update&id=' . $id,
        ], 'admin');
    }

    public function update(): void
    {
        $this->requireAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        $nama = trim((string) ($_POST['nama_bahan'] ?? ''));
        $deskripsi = trim((string) ($_POST['deskripsi'] ?? ''));

        if ($nama === '') {
            flash('error', 'Nama bahan wajib diisi.');
            set_old($_POST);
            redirect('ingredient/edit&id=' . $id);
        }

        $this->ingredientModel->updateIngredient($id, [
            'nama_bahan' => $nama,
            'deskripsi' => $deskripsi,
        ]);

        clear_old();
        flash('success', 'Bahan berhasil diperbarui.');
        redirect('ingredient/index');
    }

    public function delete(): void
    {
        $this->requireAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        $this->ingredientModel->delete($id);
        flash('success', 'Bahan berhasil dihapus.');
        redirect('ingredient/index');
    }
}
