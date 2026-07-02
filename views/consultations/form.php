<div class="card shadow-sm border-0">
    <div class="card-body p-4 p-lg-5">
        <div class="mb-4">
            <h2 class="h4 fw-bold mb-2">Form Konsultasi</h2>
            <p class="text-muted mb-0">Pilih bahan yang Anda miliki untuk menjalankan Forward Chaining.</p>
        </div>
        <form method="POST" action="<?= route_url('consultation/process') ?>">
            <?= csrf_field() ?>

            <!-- ===================== KONDISI KESEHATAN ===================== -->
            <div class="mb-5">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="health-icon-wrap">
                        <i class="bi bi-heart-pulse-fill text-danger"></i>
                    </span>
                    <div>
                        <h3 class="h5 fw-bold mb-0">Riwayat Kesehatan <span class="badge text-bg-secondary fw-normal" style="font-size:.7rem;">Opsional</span></h3>
                        <p class="text-muted small mb-0">Centang kondisi yang Anda miliki agar menu makan menyesuaikan.</p>
                    </div>
                </div>
                <div class="condition-grid">
                    <?php foreach ($conditions as $condition): ?>
                        <label class="condition-card" id="condition-label-<?= e($condition['id']) ?>">
                            <input type="checkbox"
                                   name="condition_ids[]"
                                   value="<?= e($condition['id']) ?>"
                                   class="condition-checkbox">
                            <div class="condition-card-inner">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="bi bi-shield-exclamation text-danger condition-icon"></i>
                                    <span class="condition-name fw-semibold"><?= e($condition['nama_kondisi']) ?></span>
                                </div>
                                <?php if ($condition['excluded_names']): ?>
                                    <small class="text-muted d-block">
                                        <i class="bi bi-x-circle-fill text-danger me-1" style="font-size:.7rem;"></i>
                                        Pantang: <?= e($condition['excluded_names']) ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <i class="bi bi-check-circle-fill condition-check-icon"></i>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- ============================================================ -->

            <!-- BAHAN YANG DIMILIKI -->
            <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="health-icon-wrap">
                        <i class="bi bi-basket2-fill text-success"></i>
                    </span>
                    <div>
                        <h3 class="h5 fw-bold mb-0">Bahan yang Dimiliki</h3>
                        <p class="text-muted small mb-0">Pilih bahan yang tersedia di dapur Anda.</p>
                    </div>
                </div>
                <div class="ingredient-grid mb-4">
                    <?php foreach ($ingredients as $ingredient): ?>
                        <label class="ingredient-card">
                            <input type="checkbox" name="ingredient_ids[]" value="<?= e($ingredient['id']) ?>">
                            <span class="ingredient-name"><?= e($ingredient['nama_bahan']) ?></span>
                            <small class="text-muted d-block"><?= e($ingredient['deskripsi'] ?: 'Bahan umum') ?></small>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-lg">Proses Konsultasi</button>
                <a href="<?= route_url('consultation/history') ?>" class="btn btn-outline-secondary btn-lg">Riwayat Saya</a>
            </div>
        </form>
    </div>
</div>
