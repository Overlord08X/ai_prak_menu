<?php
declare(strict_types=1);

class RecipeModel extends BaseModel
{
    protected string $table = 'recipes';

    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO recipes (nama_resep, deskripsi, langkah_memasak, gambar) VALUES (:nama_resep, :deskripsi, :langkah_memasak, :gambar)');
        return $stmt->execute([
            'nama_resep' => $data['nama_resep'],
            'deskripsi' => $data['deskripsi'],
            'langkah_memasak' => $data['langkah_memasak'],
            'gambar' => $data['gambar'],
        ]);
    }

    public function updateRecipe(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare('UPDATE recipes SET nama_resep = :nama_resep, deskripsi = :deskripsi, langkah_memasak = :langkah_memasak, gambar = :gambar WHERE id = :id');
        return $stmt->execute([
            'nama_resep' => $data['nama_resep'],
            'deskripsi' => $data['deskripsi'],
            'langkah_memasak' => $data['langkah_memasak'],
            'gambar' => $data['gambar'],
            'id' => $id,
        ]);
    }

    public function findWithIngredients(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT r.* FROM recipes r WHERE r.id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $recipe = $stmt->fetch();
        if (!$recipe) {
            return null;
        }

        $ingredientStmt = $this->pdo->prepare('SELECT i.* FROM rule_details rd INNER JOIN rules ru ON ru.id = rd.rule_id INNER JOIN ingredients i ON i.id = rd.ingredient_id WHERE ru.recipe_id = :recipe_id ORDER BY i.nama_bahan ASC');
        $ingredientStmt->execute(['recipe_id' => $id]);
        $recipe['ingredients'] = $ingredientStmt->fetchAll();
        return $recipe;
    }

    public function allWithRulesCount(): array
    {
        $stmt = $this->pdo->query('SELECT r.*, COUNT(DISTINCT ru.id) AS rule_total FROM recipes r LEFT JOIN rules ru ON ru.recipe_id = r.id GROUP BY r.id ORDER BY r.id DESC');
        return $stmt->fetchAll();
    }

    public function findMany(array $ids): array
    {
        if ($ids === []) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->pdo->prepare('SELECT * FROM recipes WHERE id IN (' . $placeholders . ')');
        $stmt->execute(array_values($ids));
        return $stmt->fetchAll();
    }

    public function statsUsage(): array
    {
        $stmt = $this->pdo->query('SELECT r.*, COUNT(cr.id) AS usage_total FROM recipes r LEFT JOIN consultation_results cr ON cr.recipe_id = r.id GROUP BY r.id ORDER BY usage_total DESC, r.nama_resep ASC');
        return $stmt->fetchAll();
    }
}
