<?php $isEdit = !empty($ingredient); ?>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="POST" action="<?= route_url($action) ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Nama Bahan</label>
                <input type="text" name="nama_bahan" class="form-control" value="<?= e(old('nama_bahan', $ingredient['nama_bahan'] ?? '')) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4"><?= e(old('deskripsi', $ingredient['deskripsi'] ?? '')) ?></textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Perbarui' : 'Simpan' ?></button>
                <a href="<?= route_url('ingredient/index') ?>" class="btn btn-outline-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
