<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Data User</h2>
        <p class="text-muted mb-0">Kelola akun admin dan pengguna aplikasi.</p>
    </div>
    <a href="<?= route_url('user/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah User</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Konsultasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $index => $user): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="fw-semibold"><?= e($user['nama']) ?></td>
                            <td><?= e($user['email']) ?></td>
                            <td><span class="badge text-bg-<?= $user['role'] === 'admin' ? 'dark' : 'secondary' ?>"><?= e($user['role']) ?></span></td>
                            <td><?= e((string) $user['consultation_total']) ?></td>
                            <td class="text-nowrap">
                                <a href="<?= route_url('user/edit&id=' . $user['id']) ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                                <a href="<?= route_url('user/delete&id=' . $user['id']) ?>" class="btn btn-sm btn-outline-danger btn-delete">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
