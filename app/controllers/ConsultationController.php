<?php
declare(strict_types=1);

class ConsultationController extends BaseController
{
    public function __construct(
        private readonly ConsultationModel $consultationModel = new ConsultationModel(),
        private readonly IngredientModel $ingredientModel = new IngredientModel(),
        private readonly RecipeModel $recipeModel = new RecipeModel(),
        private readonly ForwardChainingService $forwardChainingService = new ForwardChainingService(),
    ) {
    }

    public function form(): void
    {
        $this->requireLogin();
        $this->render('consultations/form', [
            'title' => 'Konsultasi',
            'ingredients' => $this->ingredientModel->all('nama_bahan ASC'),
        ], auth_role('admin') ? 'admin' : 'user');
    }

    public function process(): void
    {
        $this->requireLogin();
        $ingredientIds = array_map('intval', $_POST['ingredient_ids'] ?? []);
        if ($ingredientIds === []) {
            flash('error', 'Minimal satu bahan harus dipilih.');
            redirect('consultation/form');
        }

        $user = auth_user();
        $consultationId = $this->consultationModel->createConsultation((int) $user['id']);
        $this->consultationModel->addIngredientDetails($consultationId, $ingredientIds);

        $analysis = $this->forwardChainingService->analyze($ingredientIds);
        $resultRecipeIds = array_column($analysis['matches'], 'recipe_id');
        if ($resultRecipeIds !== []) {
            $this->consultationModel->addResults($consultationId, $resultRecipeIds);
        }

        $consultation = $this->consultationModel->findDetail($consultationId);
        $this->render('consultations/result', [
            'title' => 'Hasil Inferensi',
            'analysis' => $analysis,
            'consultation' => $consultation,
        ], auth_role('admin') ? 'admin' : 'user');
    }

    public function history(): void
    {
        $this->requireLogin();
        $user = auth_user();
        $this->render('consultations/history', [
            'title' => 'Riwayat Konsultasi',
            'consultations' => $this->consultationModel->historyByUser((int) $user['id']),
        ], auth_role('admin') ? 'admin' : 'user');
    }

    public function detail(): void
    {
        $this->requireLogin();
        $id = (int) ($_GET['id'] ?? 0);
        $consultation = $this->consultationModel->findDetail($id);
        if (!$consultation) {
            flash('error', 'Riwayat konsultasi tidak ditemukan.');
            redirect('consultation/history');
        }

        $user = auth_user();
        if (!auth_role('admin') && (int) $consultation['user_id'] !== (int) $user['id']) {
            flash('error', 'Anda tidak berhak melihat riwayat ini.');
            redirect('consultation/history');
        }

        $analysis = $this->forwardChainingService->analyze(array_column($consultation['ingredients'], 'id'));
        $this->render('consultations/detail', [
            'title' => 'Detail Konsultasi',
            'consultation' => $consultation,
            'analysis' => $analysis,
        ], auth_role('admin') ? 'admin' : 'user');
    }
}
