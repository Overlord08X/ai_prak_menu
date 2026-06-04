<?php
declare(strict_types=1);

class IngredientModel extends BaseModel
{
    protected string $table = 'ingredients';

    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO ingredients (nama_bahan, deskripsi) VALUES (:nama_bahan, :deskripsi)');
        return $stmt->execute([
            'nama_bahan' => $data['nama_bahan'],
            'deskripsi' => $data['deskripsi'],
        ]);
    }

    public function updateIngredient(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare('UPDATE ingredients SET nama_bahan = :nama_bahan, deskripsi = :deskripsi WHERE id = :id');
        return $stmt->execute([
            'nama_bahan' => $data['nama_bahan'],
            'deskripsi' => $data['deskripsi'],
            'id' => $id,
        ]);
    }

    public function allWithUsage(): array
    {
        $stmt = $this->pdo->query('SELECT i.*, COUNT(rd.id) AS used_total FROM ingredients i LEFT JOIN rule_details rd ON rd.ingredient_id = i.id GROUP BY i.id ORDER BY i.id DESC');
        return $stmt->fetchAll();
    }

    public function findMany(array $ids): array
    {
        if ($ids === []) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->pdo->prepare('SELECT * FROM ingredients WHERE id IN (' . $placeholders . ') ORDER BY nama_bahan ASC');
        $stmt->execute(array_values($ids));
        return $stmt->fetchAll();
    }
}
