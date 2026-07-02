<div class="result-hero mb-4">
    <div>
        <span class="badge text-bg-light mb-3">Hasil Inferensi</span>
        <h2 class="display-6 fw-bold mb-2">Rekomendasi Resep</h2>
        <p class="text-white-50 mb-0">Hasil pencocokan bahan berdasarkan rule Forward Chaining.</p>
    </div>
</div>

<!-- KONDISI KESEHATAN AKTIF -->
<?php if (!empty($analysis['active_conditions'])): ?>
<div class="alert alert-danger border-0 shadow-sm mb-4 d-flex align-items-start gap-3" role="alert">
    <i class="bi bi-heart-pulse-fill fs-4 mt-1 flex-shrink-0"></i>
    <div>
        <strong>Filter Kesehatan Aktif</strong>
        <p class="mb-1 small text-muted">Rekomendasi resep telah disesuaikan berdasarkan kondisi Anda:</p>
        <div class="d-flex flex-wrap gap-2 mt-1">
            <?php foreach ($analysis['active_conditions'] as $condition): ?>
                <span class="badge rounded-pill bg-danger bg-opacity-15 text-danger border border-danger border-opacity-25 px-3 py-2">
                    <i class="bi bi-shield-exclamation me-1"></i><?= e($condition['nama_kondisi']) ?>
                    <?php if (!empty($condition['excluded_names'])): ?>
                        &mdash; <span class="fw-normal opacity-75">pantang: <?= e($condition['excluded_names']) ?></span>
                    <?php endif; ?>
                </span>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h3 class="h5 fw-bold mb-3">Bahan yang Dipilih</h3>
        <div class="d-flex flex-wrap gap-2">
            <?php foreach ($analysis['selected_ingredients'] as $ingredient): ?>
                <span class="badge rounded-pill text-bg-secondary px-3 py-2"><?= e($ingredient['nama_bahan']) ?></span>
            <?php endforeach; ?>
            <?php if ($analysis['selected_ingredients'] === []): ?>
                <span class="text-muted">Tidak ada bahan dipilih.</span>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- RESEP COCOK (PENUH) -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h3 class="h5 fw-bold mb-3">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>Resep yang Cocok
                </h3>
                <?php if ($analysis['matches'] !== []): ?>
                    <div class="row g-3">
                        <?php foreach ($analysis['matches'] as $match): ?>
                            <div class="col-12 col-lg-6">
                                <div class="match-card h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h4 class="h5 fw-bold mb-1"><?= e($match['recipe_name']) ?></h4>
                                            <p class="text-muted mb-0"><?= e($match['recipe_description'] ?: 'Tidak ada deskripsi.') ?></p>
                                        </div>
                                        <span class="badge text-bg-success fs-6"><?= e(number_format((float) $match['percentage'], 2)) ?>%</span>
                                    </div>
                                    <div class="mb-3">
                                        <div class="small text-uppercase text-muted fw-semibold mb-2">Bahan yang Digunakan</div>
                                        <div class="d-flex flex-wrap gap-2">
                                            <?php foreach ($match['required_ingredients'] as $ingredient): ?>
                                                <span class="badge text-bg-light border text-dark"><?= e($ingredient['nama_bahan']) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="small text-uppercase text-muted fw-semibold mb-2">Langkah Memasak</div>
                                        <div class="recipe-steps small"><?= nl2br(e($match['recipe_steps'])) ?></div>
                                    </div>
                                    <a href="<?= route_url('recipe/show&id=' . $match['recipe_id']) ?>" class="btn btn-outline-primary">Lihat Detail</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning mb-0">Tidak ada resep yang cocok penuh dengan bahan yang dipilih.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- REKOMENDASI PARSIAL -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h3 class="h5 fw-bold mb-3">
                    <i class="bi bi-bar-chart-fill text-warning me-2"></i>Rekomendasi Parsial
                </h3>
                <?php if ($analysis['suggestions'] !== []): ?>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Resep</th>
                                    <th>Kecocokan</th>
                                    <th>Bahan Cocok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($analysis['suggestions'] as $suggestion): ?>
                                    <tr>
                                        <td><?= e($suggestion['recipe_name']) ?></td>
                                        <td><?= e(number_format((float) $suggestion['percentage'], 2)) ?>%</td>
                                        <td><?= e(implode(', ', array_column($suggestion['matched_ingredients'], 'nama_bahan'))) ?></td>
                                        <td><a href="<?= route_url('recipe/show&id=' . $suggestion['recipe_id']) ?>" class="btn btn-sm btn-outline-primary">Detail</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">Tidak ada rekomendasi parsial.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- RESEP DIHINDARI (karena kondisi penyakit) -->
    <?php if (!empty($analysis['excluded_recipes'])): ?>
    <div class="col-12">
        <div class="card shadow-sm border-danger border-opacity-25">
            <div class="card-header bg-danger bg-opacity-10 border-0 d-flex align-items-center gap-2">
                <i class="bi bi-slash-circle-fill text-danger fs-5"></i>
                <div>
                    <h3 class="h5 fw-bold mb-0 text-danger">Resep Dihindari</h3>
                    <p class="text-muted small mb-0">Resep berikut mengandung bahan yang tidak sesuai dengan kondisi kesehatan Anda.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <?php foreach ($analysis['excluded_recipes'] as $excluded): ?>
                        <div class="col-12 col-lg-6">
                            <div class="excluded-recipe-card border border-danger border-opacity-25 rounded-4 p-3 h-100 bg-danger bg-opacity-5">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h4 class="h6 fw-bold mb-0 text-danger">
                                        <i class="bi bi-x-circle me-1"></i><?= e($excluded['recipe_name']) ?>
                                    </h4>
                                    <a href="<?= route_url('recipe/show&id=' . $excluded['recipe_id']) ?>"
                                       class="btn btn-outline-secondary btn-sm">Detail</a>
                                </div>
                                <p class="text-muted small mb-2"><?= e($excluded['recipe_description'] ?: 'Tidak ada deskripsi.') ?></p>
                                <div class="d-flex flex-wrap gap-1 align-items-center">
                                    <span class="small text-danger fw-semibold me-1">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i>Mengandung pantangan:
                                    </span>
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
    </div>
    <?php endif; ?>
</div>
