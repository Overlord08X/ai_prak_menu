<?php $isEdit = !empty($rule); $selectedIngredients = $rule['ingredient_ids'] ?? []; ?>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="POST" action="<?= route_url($action) ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Resep</label>
                <select name="recipe_id" class="form-select" required>
                    <option value="">Pilih Resep</option>
                    <?php foreach ($recipes as $recipeOption): ?>
                        <option value="<?= e($recipeOption['id']) ?>" <?= selected([old('recipe_id', $rule['recipe_id'] ?? '')], $recipeOption['id']) ?>><?= e($recipeOption['nama_resep']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Bahan Premis</label>
                <div class="ingredient-grid">
                    <?php foreach ($ingredients as $ingredient): ?>
                        <label class="ingredient-chip">
                            <input type="checkbox" name="ingredient_ids[]" value="<?= e($ingredient['id']) ?>" <?= checked(old('ingredient_ids', $selectedIngredients), $ingredient['id']) ?>>
                            <span><?= e($ingredient['nama_bahan']) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Perbarui' : 'Simpan' ?></button>
                <a href="<?= route_url('rule/index') ?>" class="btn btn-outline-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
