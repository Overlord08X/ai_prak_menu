<?php
declare(strict_types=1);

class RuleController extends BaseController
{
    public function __construct(
        private readonly RuleModel $ruleModel = new RuleModel(),
        private readonly RecipeModel $recipeModel = new RecipeModel(),
        private readonly IngredientModel $ingredientModel = new IngredientModel(),
    ) {
    }

    public function index(): void
    {
        $this->requireAdmin();
        $this->render('admin/rules/index', [
            'title' => 'Data Rule',
            'rules' => $this->ruleModel->allWithDetails(),
        ], 'admin');
    }

    public function create(): void
    {
        $this->requireAdmin();
        $this->render('admin/rules/form', [
            'title' => 'Tambah Rule',
            'rule' => null,
            'action' => 'rule/store',
            'recipes' => $this->recipeModel->all('nama_resep ASC'),
            'ingredients' => $this->ingredientModel->all('nama_bahan ASC'),
        ], 'admin');
    }

    public function store(): void
    {
        $this->requireAdmin();
        $recipeId = (int) ($_POST['recipe_id'] ?? 0);
        $ingredientIds = array_map('intval', $_POST['ingredient_ids'] ?? []);

        if ($recipeId <= 0 || $ingredientIds === []) {
            flash('error', 'Resep dan minimal satu bahan wajib dipilih.');
            set_old($_POST);
            redirect('rule/create');
        }

        $this->ruleModel->createRule($recipeId, $ingredientIds);
        clear_old();
        flash('success', 'Rule berhasil ditambahkan.');
        redirect('rule/index');
    }

    public function edit(): void
    {
        $this->requireAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        $rule = $this->ruleModel->findRule($id);
        if (!$rule) {
            flash('error', 'Rule tidak ditemukan.');
            redirect('rule/index');
        }

        $this->render('admin/rules/form', [
            'title' => 'Edit Rule',
            'rule' => $rule,
            'action' => 'rule/update&id=' . $id,
            'recipes' => $this->recipeModel->all('nama_resep ASC'),
            'ingredients' => $this->ingredientModel->all('nama_bahan ASC'),
        ], 'admin');
    }

    public function update(): void
    {
        $this->requireAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        $recipeId = (int) ($_POST['recipe_id'] ?? 0);
        $ingredientIds = array_map('intval', $_POST['ingredient_ids'] ?? []);

        if ($recipeId <= 0 || $ingredientIds === []) {
            flash('error', 'Resep dan minimal satu bahan wajib dipilih.');
            set_old($_POST);
            redirect('rule/edit&id=' . $id);
        }

        $this->ruleModel->updateRule($id, $recipeId, $ingredientIds);
        clear_old();
        flash('success', 'Rule berhasil diperbarui.');
        redirect('rule/index');
    }

    public function delete(): void
    {
        $this->requireAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        $this->ruleModel->deleteRule($id);
        flash('success', 'Rule berhasil dihapus.');
        redirect('rule/index');
    }
}
