<?php
declare(strict_types=1);

class ForwardChainingService
{
    private IngredientModel $ingredientModel;
    private RecipeModel $recipeModel;
    private RuleModel $ruleModel;

    public function __construct(?IngredientModel $ingredientModel = null, ?RecipeModel $recipeModel = null, ?RuleModel $ruleModel = null)
    {
        $this->ingredientModel = $ingredientModel ?? new IngredientModel();
        $this->recipeModel = $recipeModel ?? new RecipeModel();
        $this->ruleModel = $ruleModel ?? new RuleModel();
    }

    public function analyze(array $selectedIngredientIds): array
    {
        $selectedIngredientIds = array_values(array_unique(array_map('intval', $selectedIngredientIds)));
        $selectedIngredients = $this->ingredientModel->findMany($selectedIngredientIds);
        $rules = $this->ruleModel->allWithDetails();
        $matchedRecipes = [];
        $suggestions = [];

        foreach ($rules as $rule) {
            $requiredIds = $rule['ingredient_ids'];
            $matchedIds = array_values(array_intersect($requiredIds, $selectedIngredientIds));
            $requiredCount = count($requiredIds);
            $matchedCount = count($matchedIds);
            $percentage = $requiredCount > 0 ? round(($matchedCount / $requiredCount) * 100, 2) : 0.0;

            $recipeId = (int) $rule['recipe_id'];
            $recipe = $this->recipeModel->find($recipeId);
            if (!$recipe) {
                continue;
            }

            $ruleIngredients = $this->ingredientModel->findMany($requiredIds);
            $matchRow = [
                'rule_id' => (int) $rule['rule_id'],
                'recipe_id' => $recipeId,
                'recipe_name' => $recipe['nama_resep'],
                'recipe_description' => $recipe['deskripsi'],
                'recipe_steps' => $recipe['langkah_memasak'],
                'recipe_image' => $recipe['gambar'],
                'required_ingredients' => $ruleIngredients,
                'matched_ingredient_ids' => $matchedIds,
                'matched_ingredients' => $this->ingredientModel->findMany($matchedIds),
                'percentage' => $percentage,
                'status' => $matchedCount === $requiredCount && $requiredCount > 0 ? 'aktif' : 'parsial',
            ];

            if ($matchRow['status'] === 'aktif') {
                $matchedRecipes[$recipeId] = $matchRow;
            } elseif ($percentage > 0) {
                $suggestions[$recipeId] = $matchRow;
            }
        }

        usort($matchedRecipes, static function (array $left, array $right): int {
            if ($left['percentage'] === $right['percentage']) {
                return strcmp($left['recipe_name'], $right['recipe_name']);
            }

            return $right['percentage'] <=> $left['percentage'];
        });
        usort($suggestions, static function (array $left, array $right): int {
            if ($left['percentage'] === $right['percentage']) {
                return strcmp($left['recipe_name'], $right['recipe_name']);
            }

            return $right['percentage'] <=> $left['percentage'];
        });

        return [
            'selected_ingredient_ids' => $selectedIngredientIds,
            'selected_ingredients' => $selectedIngredients,
            'matches' => array_values($matchedRecipes),
            'suggestions' => array_values($suggestions),
        ];
    }
}
