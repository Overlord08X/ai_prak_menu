<?php
declare(strict_types=1);

class MedicalConditionModel extends BaseModel
{
    protected string $table = 'medical_conditions';

    /**
     * Ambil semua kondisi penyakit beserta daftar bahan pantangannya.
     */
    public function allWithExcluded(): array
    {
        $stmt = $this->pdo->query(
            'SELECT mc.*, GROUP_CONCAT(cei.ingredient_id ORDER BY cei.ingredient_id SEPARATOR ",") AS excluded_ids,
             GROUP_CONCAT(i.nama_bahan ORDER BY cei.ingredient_id SEPARATOR ", ") AS excluded_names
             FROM medical_conditions mc
             LEFT JOIN condition_excluded_ingredients cei ON cei.condition_id = mc.id
             LEFT JOIN ingredients i ON i.id = cei.ingredient_id
             GROUP BY mc.id
             ORDER BY mc.nama_kondisi ASC'
        );
        $conditions = $stmt->fetchAll();
        foreach ($conditions as &$condition) {
            $condition['excluded_ids'] = $condition['excluded_ids'] !== null
                ? array_map('intval', explode(',', $condition['excluded_ids']))
                : [];
            $condition['excluded_names'] = $condition['excluded_names'] ?? '';
        }
        return $conditions;
    }

    /**
     * Ambil daftar ID bahan yang harus dihindari berdasarkan kondisi penyakit yang dipilih.
     */
    public function getExcludedIngredientIds(array $conditionIds): array
    {
        if ($conditionIds === []) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($conditionIds), '?'));
        $stmt = $this->pdo->prepare(
            'SELECT DISTINCT cei.ingredient_id FROM condition_excluded_ingredients cei
             WHERE cei.condition_id IN (' . $placeholders . ')'
        );
        $stmt->execute(array_values($conditionIds));
        return array_map('intval', array_column($stmt->fetchAll(), 'ingredient_id'));
    }

    /**
     * Ambil detail kondisi penyakit beserta bahan pantangannya berdasarkan ID kondisi.
     */
    public function findManyWithExcluded(array $conditionIds): array
    {
        if ($conditionIds === []) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($conditionIds), '?'));
        $stmt = $this->pdo->prepare(
            'SELECT mc.*,
             GROUP_CONCAT(i.nama_bahan ORDER BY i.nama_bahan SEPARATOR ", ") AS excluded_names
             FROM medical_conditions mc
             LEFT JOIN condition_excluded_ingredients cei ON cei.condition_id = mc.id
             LEFT JOIN ingredients i ON i.id = cei.ingredient_id
             WHERE mc.id IN (' . $placeholders . ')
             GROUP BY mc.id
             ORDER BY mc.nama_kondisi ASC'
        );
        $stmt->execute(array_values($conditionIds));
        return $stmt->fetchAll();
    }
}
