<div class="card shadow-sm border-0 mb-4 overflow-hidden">
    <div class="row g-0">
        <div class="col-12 col-lg-5">
            <div class="recipe-hero">
                <?php if (!empty($recipe['gambar'])): ?>
                    <img src="<?= e($recipe['gambar']) ?>" alt="<?= e($recipe['nama_resep']) ?>" class="recipe-image">
                <?php else: ?>
                    <div class="recipe-image-placeholder">CF</div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-12 col-lg-7">
            <div class="card-body p-4 p-lg-5">
                <h2 class="h3 fw-bold mb-2"><?= e($recipe['nama_resep']) ?></h2>
                <p class="text-muted mb-4"><?= e($recipe['deskripsi'] ?: 'Tidak ada deskripsi.') ?></p>
                <h3 class="h5 fw-bold">Bahan yang Digunakan</h3>
                <ul class="list-group list-group-flush mb-4">
                    <?php foreach ($recipe['ingredients'] as $ingredient): ?>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span><?= e($ingredient['nama_bahan']) ?></span>
                        </li>
                    <?php endforeach; ?>
                    <?php if ($recipe['ingredients'] === []): ?>
                        <li class="list-group-item px-0 text-muted">Belum ada rule yang terhubung.</li>
                    <?php endif; ?>
                </ul>
                <h3 class="h5 fw-bold">Langkah Memasak</h3>
                <div class="recipe-steps"><?= nl2br(e($recipe['langkah_memasak'])) ?></div>
            </div>
        </div>
    </div>
</div>
