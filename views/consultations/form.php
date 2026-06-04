<div class="card shadow-sm border-0">
    <div class="card-body p-4 p-lg-5">
        <div class="mb-4">
            <h2 class="h4 fw-bold mb-2">Form Konsultasi</h2>
            <p class="text-muted mb-0">Pilih bahan yang Anda miliki untuk menjalankan Forward Chaining.</p>
        </div>
        <form method="POST" action="<?= route_url('consultation/process') ?>">
            <?= csrf_field() ?>
            <div class="ingredient-grid mb-4">
                <?php foreach ($ingredients as $ingredient): ?>
                    <label class="ingredient-card">
                        <input type="checkbox" name="ingredient_ids[]" value="<?= e($ingredient['id']) ?>">
                        <span class="ingredient-name"><?= e($ingredient['nama_bahan']) ?></span>
                        <small class="text-muted d-block"><?= e($ingredient['deskripsi'] ?: 'Bahan umum') ?></small>
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-lg">Proses Konsultasi</button>
                <a href="<?= route_url('consultation/history') ?>" class="btn btn-outline-secondary btn-lg">Riwayat Saya</a>
            </div>
        </form>
    </div>
</div>
