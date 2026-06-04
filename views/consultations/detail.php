<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h2 class="h4 fw-bold mb-1">Detail Konsultasi</h2>
                <p class="text-muted mb-0">Tanggal: <?= e(format_date($consultation['tanggal'])) ?></p>
            </div>
            <span class="badge text-bg-dark"><?= e($consultation['nama']) ?></span>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <h3 class="h5 fw-bold mb-3">Bahan Dipilih</h3>
                <ul class="list-group">
                    <?php foreach ($consultation['ingredients'] as $ingredient): ?>
                        <li class="list-group-item"><?= e($ingredient['nama_bahan']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-12 col-lg-6">
                <h3 class="h5 fw-bold mb-3">Resep Hasil</h3>
                <ul class="list-group">
                    <?php foreach ($consultation['recipes'] as $recipe): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?= e($recipe['nama_resep']) ?></span>
                            <a href="<?= route_url('recipe/show&id=' . $recipe['id']) ?>" class="btn btn-sm btn-outline-primary">Detail</a>
                        </li>
                    <?php endforeach; ?>
                    <?php if ($consultation['recipes'] === []): ?>
                        <li class="list-group-item text-muted">Tidak ada resep yang diaktifkan.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <h3 class="h5 fw-bold mb-3">Analisis Forward Chaining</h3>
        <?php if ($analysis['matches'] !== []): ?>
            <div class="row g-3">
                <?php foreach ($analysis['matches'] as $match): ?>
                    <div class="col-12 col-lg-6">
                        <div class="border rounded-4 p-3 h-100">
                            <div class="d-flex justify-content-between mb-2">
                                <strong><?= e($match['recipe_name']) ?></strong>
                                <span class="badge text-bg-success"><?= e(number_format((float) $match['percentage'], 2)) ?>%</span>
                            </div>
                            <div class="small text-muted mb-2">Bahan sesuai: <?= e(implode(', ', array_column($match['matched_ingredients'], 'nama_bahan'))) ?></div>
                            <div class="small text-muted">Rule aktif karena seluruh premis terpenuhi.</div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning mb-0">Tidak ada hasil cocok penuh untuk konsultasi ini.</div>
        <?php endif; ?>
    </div>
</div>
