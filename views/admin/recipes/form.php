<?php $isEdit = !empty($recipe); ?>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="POST" action="<?= route_url($action) ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-12 col-lg-6">
                    <label class="form-label">Nama Resep</label>
                    <input type="text" name="nama_resep" class="form-control" value="<?= e(old('nama_resep', $recipe['nama_resep'] ?? '')) ?>" required>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*">
                    <?php if (!empty($recipe['gambar'])): ?>
                        <div class="mt-2">
                            <img src="<?= e($recipe['gambar']) ?>" alt="<?= e($recipe['nama_resep']) ?>" class="img-thumbnail" style="max-height: 180px;">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"><?= e(old('deskripsi', $recipe['deskripsi'] ?? '')) ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Langkah Memasak</label>
                    <textarea name="langkah_memasak" class="form-control" rows="8" required><?= e(old('langkah_memasak', $recipe['langkah_memasak'] ?? '')) ?></textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Perbarui' : 'Simpan' ?></button>
                <a href="<?= route_url('recipe/index') ?>" class="btn btn-outline-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
