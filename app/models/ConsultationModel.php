<?php
declare(strict_types=1);

class ConsultationModel extends BaseModel
{
    protected string $table = 'consultations';

    public function createConsultation(int $userId): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO consultations (user_id, tanggal) VALUES (:user_id, NOW())');
        $stmt->execute(['user_id' => $userId]);
        return (int) $this->pdo->lastInsertId();
    }

    public function addIngredientDetails(int $consultationId, array $ingredientIds): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO consultation_details (consultation_id, ingredient_id) VALUES (:consultation_id, :ingredient_id)');
        foreach ($ingredientIds as $ingredientId) {
            $stmt->execute([
                'consultation_id' => $consultationId,
                'ingredient_id' => (int) $ingredientId,
            ]);
        }
    }

    public function addResults(int $consultationId, array $recipeIds): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO consultation_results (consultation_id, recipe_id) VALUES (:consultation_id, :recipe_id)');
        foreach ($recipeIds as $recipeId) {
            $stmt->execute([
                'consultation_id' => $consultationId,
                'recipe_id' => (int) $recipeId,
            ]);
        }
    }

    public function historyByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT c.*, u.nama, COUNT(DISTINCT cd.id) AS ingredient_total, COUNT(DISTINCT cr.id) AS recipe_total FROM consultations c INNER JOIN users u ON u.id = c.user_id LEFT JOIN consultation_details cd ON cd.consultation_id = c.id LEFT JOIN consultation_results cr ON cr.consultation_id = c.id WHERE c.user_id = :user_id GROUP BY c.id ORDER BY c.tanggal DESC');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function allHistory(): array
    {
        $stmt = $this->pdo->query('SELECT c.*, u.nama, u.email, COUNT(DISTINCT cd.id) AS ingredient_total, COUNT(DISTINCT cr.id) AS recipe_total FROM consultations c INNER JOIN users u ON u.id = c.user_id LEFT JOIN consultation_details cd ON cd.consultation_id = c.id LEFT JOIN consultation_results cr ON cr.consultation_id = c.id GROUP BY c.id ORDER BY c.tanggal DESC');
        return $stmt->fetchAll();
    }

    public function findDetail(int $consultationId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT c.*, u.nama, u.email FROM consultations c INNER JOIN users u ON u.id = c.user_id WHERE c.id = :id LIMIT 1');
        $stmt->execute(['id' => $consultationId]);
        $consultation = $stmt->fetch();
        if (!$consultation) {
            return null;
        }

        $ingredientStmt = $this->pdo->prepare('SELECT i.* FROM consultation_details cd INNER JOIN ingredients i ON i.id = cd.ingredient_id WHERE cd.consultation_id = :consultation_id ORDER BY i.nama_bahan ASC');
        $ingredientStmt->execute(['consultation_id' => $consultationId]);
        $consultation['ingredients'] = $ingredientStmt->fetchAll();

        $resultStmt = $this->pdo->prepare('SELECT r.* FROM consultation_results cr INNER JOIN recipes r ON r.id = cr.recipe_id WHERE cr.consultation_id = :consultation_id ORDER BY r.nama_resep ASC');
        $resultStmt->execute(['consultation_id' => $consultationId]);
        $consultation['recipes'] = $resultStmt->fetchAll();

        return $consultation;
    }

    public function count(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) AS total FROM consultations');
        return (int) ($stmt->fetch()['total'] ?? 0);
    }
}
