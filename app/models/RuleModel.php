<?php
declare(strict_types=1);

class RuleModel extends BaseModel
{
    protected string $table = 'rules';

    public function allWithDetails(): array
    {
        $stmt = $this->pdo->query('SELECT ru.id AS rule_id, ru.recipe_id, r.nama_resep, GROUP_CONCAT(i.id ORDER BY i.nama_bahan SEPARATOR ",") AS ingredient_ids, GROUP_CONCAT(i.nama_bahan ORDER BY i.nama_bahan SEPARATOR ", ") AS ingredient_names FROM rules ru INNER JOIN recipes r ON r.id = ru.recipe_id INNER JOIN rule_details rd ON rd.rule_id = ru.id INNER JOIN ingredients i ON i.id = rd.ingredient_id GROUP BY ru.id, ru.recipe_id, r.nama_resep ORDER BY ru.id DESC');
        $rules = $stmt->fetchAll();
        foreach ($rules as &$rule) {
            $rule['ingredient_ids'] = $rule['ingredient_ids'] !== null ? array_map('intval', explode(',', $rule['ingredient_ids'])) : [];
            $rule['ingredient_names'] = $rule['ingredient_names'] ?? '';
        }
        return $rules;
    }

    public function createRule(int $recipeId, array $ingredientIds): bool
    {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare('INSERT INTO rules (recipe_id) VALUES (:recipe_id)');
            $stmt->execute(['recipe_id' => $recipeId]);
            $ruleId = (int) $this->pdo->lastInsertId();

            $detailStmt = $this->pdo->prepare('INSERT INTO rule_details (rule_id, ingredient_id) VALUES (:rule_id, :ingredient_id)');
            foreach ($ingredientIds as $ingredientId) {
                $detailStmt->execute([
                    'rule_id' => $ruleId,
                    'ingredient_id' => (int) $ingredientId,
                ]);
            }

            $this->pdo->commit();
            return true;
        } catch (Throwable $exception) {
            $this->pdo->rollBack();
            throw $exception;
        }
    }

    public function updateRule(int $ruleId, int $recipeId, array $ingredientIds): bool
    {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare('UPDATE rules SET recipe_id = :recipe_id WHERE id = :id');
            $stmt->execute(['recipe_id' => $recipeId, 'id' => $ruleId]);

            $deleteStmt = $this->pdo->prepare('DELETE FROM rule_details WHERE rule_id = :rule_id');
            $deleteStmt->execute(['rule_id' => $ruleId]);

            $detailStmt = $this->pdo->prepare('INSERT INTO rule_details (rule_id, ingredient_id) VALUES (:rule_id, :ingredient_id)');
            foreach ($ingredientIds as $ingredientId) {
                $detailStmt->execute([
                    'rule_id' => $ruleId,
                    'ingredient_id' => (int) $ingredientId,
                ]);
            }

            $this->pdo->commit();
            return true;
        } catch (Throwable $exception) {
            $this->pdo->rollBack();
            throw $exception;
        }
    }

    public function findRule(int $ruleId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM rules WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $ruleId]);
        $rule = $stmt->fetch();
        if (!$rule) {
            return null;
        }

        $detailStmt = $this->pdo->prepare('SELECT ingredient_id FROM rule_details WHERE rule_id = :rule_id ORDER BY ingredient_id ASC');
        $detailStmt->execute(['rule_id' => $ruleId]);
        $rule['ingredient_ids'] = array_map('intval', array_column($detailStmt->fetchAll(), 'ingredient_id'));
        return $rule;
    }

    public function deleteRule(int $ruleId): bool
    {
        $this->pdo->beginTransaction();
        try {
            $this->pdo->prepare('DELETE FROM rule_details WHERE rule_id = :rule_id')->execute(['rule_id' => $ruleId]);
            $this->pdo->prepare('DELETE FROM rules WHERE id = :id')->execute(['id' => $ruleId]);
            $this->pdo->commit();
            return true;
        } catch (Throwable $exception) {
            $this->pdo->rollBack();
            throw $exception;
        }
    }

    public function count(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) AS total FROM rules');
        return (int) ($stmt->fetch()['total'] ?? 0);
    }
}
