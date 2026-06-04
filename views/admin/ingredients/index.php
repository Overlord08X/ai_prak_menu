<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Data Bahan</h2>
        <p class="text-muted mb-0">Kelola seluruh bahan makanan yang digunakan dalam rule.</p>
    </div>
    <a href="<?= route_url('ingredient/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Bahan</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Bahan</th>
                        <th>Deskripsi</th>
                        <th>Dipakai di Rule</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ingredients as $index => $ingredient): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="fw-semibold"><?= e($ingredient['nama_bahan']) ?></td>
                            <td><?= e($ingredient['deskripsi'] ?: '-') ?></td>
                            <td><?= e((string) $ingredient['used_total']) ?></td>
                            <td class="text-nowrap">
                                <a href="<?= route_url('ingredient/edit&id=' . $ingredient['id']) ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                                <a href="<?= route_url('ingredient/delete&id=' . $ingredient['id']) ?>" class="btn btn-sm btn-outline-danger btn-delete">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
