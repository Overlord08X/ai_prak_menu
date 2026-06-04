<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Data Rule</h2>
        <p class="text-muted mb-0">Relasi bahan ke resep untuk proses Forward Chaining.</p>
    </div>
    <a href="<?= route_url('rule/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Rule</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Resep</th>
                        <th>Premis Bahan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rules as $index => $rule): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="fw-semibold"><?= e($rule['nama_resep']) ?></td>
                            <td><?= e($rule['ingredient_names']) ?></td>
                            <td class="text-nowrap">
                                <a href="<?= route_url('rule/edit&id=' . $rule['rule_id']) ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                                <a href="<?= route_url('rule/delete&id=' . $rule['rule_id']) ?>" class="btn btn-sm btn-outline-danger btn-delete">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
