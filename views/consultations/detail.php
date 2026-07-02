<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h2 class="h4 fw-bold mb-1">Detail Konsultasi</h2>
                <p class="text-muted mb-0">Tanggal: <?= e(format_date($consultation['tanggal'])) ?></p>
            </div>
            <span class="badge text-bg-dark"><?= e($consultation['nama']) ?></span>
        </div>

        <!-- Kondisi Penyakit -->
        <?php if (!empty($conditions)): ?>
        <div class="mb-4">
            <h3 class="h6 fw-bold text-danger mb-2">
                <i class="bi bi-heart-pulse-fill me-1"></i>Kondisi Kesehatan saat Konsultasi
            </h3>
            <div class="d-flex flex-wrap gap-2">
                <?php foreach ($conditions as $condition): ?>
                    <span class="badge rounded-pill bg-danger bg-opacity-15 text-danger border border-danger border-opacity-25 px-3 py-2">
                        <i class="bi bi-shield-exclamation me-1"></i><?= e($condition['nama_kondisi']) ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

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

<div class="card shadow-sm border-0 mb-4">
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

<!-- Resep yang Dihindari -->
<?php if (!empty($analysis['excluded_recipes'])): ?>
<div class="card shadow-sm border-danger border-opacity-25">
    <div class="card-header bg-danger bg-opacity-10 border-0 d-flex align-items-center gap-2">
        <i class="bi bi-slash-circle-fill text-danger fs-5"></i>
        <div>
            <h3 class="h5 fw-bold mb-0 text-danger">Resep Dihindari</h3>
            <p class="text-muted small mb-0">Resep berikut tidak direkomendasikan karena mengandung bahan pantangan.</p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <?php foreach ($analysis['excluded_recipes'] as $excluded): ?>
                <div class="col-12 col-lg-6">
                    <div class="border border-danger border-opacity-25 rounded-4 p-3 bg-danger bg-opacity-5">
                        <h4 class="h6 fw-bold text-danger mb-1">
                            <i class="bi bi-x-circle me-1"></i><?= e($excluded['recipe_name']) ?>
                        </h4>
                        <div class="d-flex flex-wrap gap-1 mt-2">
                            <span class="small text-danger fw-semibold me-1">Pantangan:</span>
                            <?php foreach ($excluded['forbidden_ingredients'] as $forbidden): ?>
                                <span class="badge bg-danger bg-opacity-15 text-danger border border-danger border-opacity-25">
                                    <?= e($forbidden) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>
