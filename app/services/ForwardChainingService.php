<?php
declare(strict_types=1);

class ForwardChainingService
{
    private IngredientModel $ingredientModel;
    private RecipeModel $recipeModel;
    private RuleModel $ruleModel;
    private MedicalConditionModel $medicalConditionModel;

    public function __construct(
        ?IngredientModel $ingredientModel = null,
        ?RecipeModel $recipeModel = null,
        ?RuleModel $ruleModel = null,
        ?MedicalConditionModel $medicalConditionModel = null,
    ) {
        $this->ingredientModel = $ingredientModel ?? new IngredientModel();
        $this->recipeModel = $recipeModel ?? new RecipeModel();
        $this->ruleModel = $ruleModel ?? new RuleModel();
        $this->medicalConditionModel = $medicalConditionModel ?? new MedicalConditionModel();
    }

    /**
     * Analisis forward chaining dengan filter kondisi penyakit.
     *
     * @param int[] $selectedIngredientIds  Bahan yang dimiliki user
     * @param int[] $conditionIds           Kondisi penyakit yang dimiliki user (bisa kosong)
     * @return array{
     *   selected_ingredient_ids: int[],
     *   selected_ingredients: array,
     *   active_conditions: array,
     *   excluded_ingredient_ids: int[],
     *   matches: array,
     *   suggestions: array,
     *   excluded_recipes: array,
     * }
     */
    public function analyze(array $selectedIngredientIds, array $conditionIds = []): array
    {
        $selectedIngredientIds = array_values(array_unique(array_map('intval', $selectedIngredientIds)));
        $conditionIds = array_values(array_unique(array_map('intval', $conditionIds)));

        $selectedIngredients = $this->ingredientModel->findMany($selectedIngredientIds);

        // Ambil kondisi penyakit aktif & bahan yang harus dihindari
        $activeConditions = $conditionIds !== []
            ? $this->medicalConditionModel->findManyWithExcluded($conditionIds)
            : [];
        $excludedIngredientIds = $conditionIds !== []
            ? $this->medicalConditionModel->getExcludedIngredientIds($conditionIds)
            : [];

        $rules = $this->ruleModel->allWithDetails();
        $matchedRecipes = [];
        $suggestions = [];
        $excludedRecipes = [];

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

            // --- Cek apakah resep ini mengandung bahan pantangan ---
            $forbiddenInRecipe = [];
            if ($excludedIngredientIds !== []) {
                $forbiddenIds = array_values(array_intersect($requiredIds, $excludedIngredientIds));
                if ($forbiddenIds !== []) {
                    $forbiddenIngredients = $this->ingredientModel->findMany($forbiddenIds);
                    foreach ($forbiddenIngredients as $fi) {
                        $forbiddenInRecipe[] = $fi['nama_bahan'];
                    }
                }
            }

            $matchRow = [
                'rule_id'               => (int) $rule['rule_id'],
                'recipe_id'             => $recipeId,
                'recipe_name'           => $recipe['nama_resep'],
                'recipe_description'    => $recipe['deskripsi'],
                'recipe_steps'          => $recipe['langkah_memasak'],
                'recipe_image'          => $recipe['gambar'],
                'required_ingredients'  => $ruleIngredients,
                'matched_ingredient_ids'=> $matchedIds,
                'matched_ingredients'   => $this->ingredientModel->findMany($matchedIds),
                'percentage'            => $percentage,
                'status'                => $matchedCount === $requiredCount && $requiredCount > 0 ? 'aktif' : 'parsial',
                'forbidden_ingredients' => $forbiddenInRecipe,
            ];

            // Jika resep mengandung bahan pantangan, masuk ke excluded_recipes
            if ($forbiddenInRecipe !== []) {
                // Simpan ke excluded hanya sekali per recipe_id
                if (!isset($excludedRecipes[$recipeId])) {
                    $excludedRecipes[$recipeId] = $matchRow;
                }
                continue; // Skip dari matches & suggestions
            }

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
        usort($excludedRecipes, static function (array $left, array $right): int {
            return strcmp($left['recipe_name'], $right['recipe_name']);
        });

        return [
            'selected_ingredient_ids' => $selectedIngredientIds,
            'selected_ingredients'    => $selectedIngredients,
            'active_conditions'       => $activeConditions,
            'excluded_ingredient_ids' => $excludedIngredientIds,
            'matches'                 => array_values($matchedRecipes),
            'suggestions'             => array_values($suggestions),
            'excluded_recipes'        => array_values($excludedRecipes),
        ];
    }
}
