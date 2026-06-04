<?php
declare(strict_types=1);

class RecipeController extends BaseController
{
    public function __construct(
        private readonly RecipeModel $recipeModel = new RecipeModel(),
        private readonly IngredientModel $ingredientModel = new IngredientModel(),
    ) {
    }

    public function index(): void
    {
        $this->requireAdmin();
        $this->render('admin/recipes/index', [
            'title' => 'Data Resep',
            'recipes' => $this->recipeModel->allWithRulesCount(),
        ], 'admin');
    }

    public function show(): void
    {
        $this->requireLogin();
        $id = (int) ($_GET['id'] ?? 0);
        $recipe = $this->recipeModel->findWithIngredients($id);
        if (!$recipe) {
            flash('error', 'Resep tidak ditemukan.');
            redirect('dashboard/user');
        }

        $this->render('recipes/detail', [
            'title' => $recipe['nama_resep'],
            'recipe' => $recipe,
        ], auth_role('admin') ? 'admin' : 'user');
    }

    public function create(): void
    {
        $this->requireAdmin();
        $this->render('admin/recipes/form', [
            'title' => 'Tambah Resep',
            'recipe' => null,
            'action' => 'recipe/store',
            'ingredients' => $this->ingredientModel->all('nama_bahan ASC'),
        ], 'admin');
    }

    public function store(): void
    {
        $this->requireAdmin();
        $nama = trim((string) ($_POST['nama_resep'] ?? ''));
        $deskripsi = trim((string) ($_POST['deskripsi'] ?? ''));
        $langkah = trim((string) ($_POST['langkah_memasak'] ?? ''));
        $gambar = upload_image($_FILES['gambar'] ?? null);

        if ($nama === '' || $langkah === '') {
            flash('error', 'Nama resep dan langkah memasak wajib diisi.');
            set_old($_POST);
            redirect('recipe/create');
        }

        $this->recipeModel->create([
            'nama_resep' => $nama,
            'deskripsi' => $deskripsi,
            'langkah_memasak' => $langkah,
            'gambar' => $gambar,
        ]);

        clear_old();
        flash('success', 'Resep berhasil ditambahkan.');
        redirect('recipe/index');
    }

    public function edit(): void
    {
        $this->requireAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        $recipe = $this->recipeModel->find($id);
        if (!$recipe) {
            flash('error', 'Resep tidak ditemukan.');
            redirect('recipe/index');
        }

        $this->render('admin/recipes/form', [
            'title' => 'Edit Resep',
            'recipe' => $recipe,
            'action' => 'recipe/update&id=' . $id,
            'ingredients' => $this->ingredientModel->all('nama_bahan ASC'),
        ], 'admin');
    }

    public function update(): void
    {
        $this->requireAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        $recipe = $this->recipeModel->find($id);
        if (!$recipe) {
            flash('error', 'Resep tidak ditemukan.');
            redirect('recipe/index');
        }

        $nama = trim((string) ($_POST['nama_resep'] ?? ''));
        $deskripsi = trim((string) ($_POST['deskripsi'] ?? ''));
        $langkah = trim((string) ($_POST['langkah_memasak'] ?? ''));
        $gambar = upload_image($_FILES['gambar'] ?? null, $recipe['gambar'] ?? null);

        if ($nama === '' || $langkah === '') {
            flash('error', 'Nama resep dan langkah memasak wajib diisi.');
            set_old($_POST);
            redirect('recipe/edit&id=' . $id);
        }

        $this->recipeModel->updateRecipe($id, [
            'nama_resep' => $nama,
            'deskripsi' => $deskripsi,
            'langkah_memasak' => $langkah,
            'gambar' => $gambar,
        ]);

        clear_old();
        flash('success', 'Resep berhasil diperbarui.');
        redirect('recipe/index');
    }

    public function delete(): void
    {
        $this->requireAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        $this->recipeModel->delete($id);
        flash('success', 'Resep berhasil dihapus.');
        redirect('recipe/index');
    }
}
