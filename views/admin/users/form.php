<?php $isEdit = !empty($user); ?>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="POST" action="<?= route_url($action) ?>">
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-12 col-lg-6">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= e(old('nama', $user['nama'] ?? '')) ?>" required>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= e(old('email', $user['email'] ?? '')) ?>" required>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="form-label">Password <?= $isEdit ? '(kosongkan jika tidak diubah)' : '' ?></label>
                    <input type="password" name="password" class="form-control" <?= $isEdit ? '' : 'required' ?>>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="user" <?= selected([old('role', $user['role'] ?? 'user')], 'user') ?>>User</option>
                        <option value="admin" <?= selected([old('role', $user['role'] ?? 'user')], 'admin') ?>>Admin</option>
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Perbarui' : 'Simpan' ?></button>
                <a href="<?= route_url('user/index') ?>" class="btn btn-outline-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
