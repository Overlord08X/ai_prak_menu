<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Data Resep</h2>
        <p class="text-muted mb-0">Kelola resep, gambar, dan langkah memasak.</p>
    </div>
    <a href="<?= route_url('recipe/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Resep</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Resep</th>
                        <th>Deskripsi</th>
                        <th>Rule</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recipes as $index => $recipe): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="fw-semibold"><?= e($recipe['nama_resep']) ?></td>
                            <td><?= e($recipe['deskripsi'] ?: '-') ?></td>
                            <td><?= e((string) $recipe['rule_total']) ?></td>
                            <td class="text-nowrap">
                                <a href="<?= route_url('recipe/show&id=' . $recipe['id']) ?>" class="btn btn-sm btn-outline-info">Detail</a>
                                <a href="<?= route_url('recipe/edit&id=' . $recipe['id']) ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                                <a href="<?= route_url('recipe/delete&id=' . $recipe['id']) ?>" class="btn btn-sm btn-outline-danger btn-delete">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
