<?php
declare(strict_types=1);

class DashboardController extends BaseController
{
    public function __construct(
        private readonly UserModel $userModel = new UserModel(),
        private readonly RecipeModel $recipeModel = new RecipeModel(),
        private readonly IngredientModel $ingredientModel = new IngredientModel(),
        private readonly RuleModel $ruleModel = new RuleModel(),
        private readonly ConsultationModel $consultationModel = new ConsultationModel(),
    ) {
    }

    public function admin(): void
    {
        $this->requireAdmin();

        $data = [
            'title' => 'Dashboard Admin',
            'totalUsers' => $this->userModel->count(),
            'totalRecipes' => $this->recipeModel->count(),
            'totalIngredients' => $this->ingredientModel->count(),
            'totalRules' => $this->ruleModel->count(),
            'totalConsultations' => $this->consultationModel->count(),
            'recentConsultations' => array_slice($this->consultationModel->allHistory(), 0, 5),
            'recipeStats' => array_slice($this->recipeModel->statsUsage(), 0, 5),
        ];

        $this->render('admin/dashboard', $data, 'admin');
    }

    public function user(): void
    {
        $this->requireLogin();
        $user = auth_user();
        $history = $this->consultationModel->historyByUser((int) $user['id']);

        $data = [
            'title' => 'Dashboard User',
            'user' => $user,
            'totalConsultations' => count($history),
            'latestHistory' => array_slice($history, 0, 5),
            'totalRecipes' => $this->recipeModel->count(),
            'totalIngredients' => $this->ingredientModel->count(),
        ];

        $this->render('user/dashboard', $data, 'user');
    }
}
