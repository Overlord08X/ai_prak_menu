<?php
declare(strict_types=1);

class ReportController extends BaseController
{
    public function __construct(
        private readonly ConsultationModel $consultationModel = new ConsultationModel(),
        private readonly RecipeModel $recipeModel = new RecipeModel(),
    ) {
    }

    public function consultations(): void
    {
        $this->requireAdmin();
        $this->render('reports/consultations', [
            'title' => 'Laporan Riwayat Konsultasi',
            'consultations' => $this->consultationModel->allHistory(),
        ], 'admin');
    }

    public function recipeUsage(): void
    {
        $this->requireAdmin();
        $this->render('reports/recipe_usage', [
            'title' => 'Statistik Penggunaan Resep',
            'recipeStats' => $this->recipeModel->statsUsage(),
        ], 'admin');
    }
}
