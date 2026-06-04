<div class="card shadow-sm border-0">
    <div class="card-body">
        <h2 class="h4 fw-bold mb-3">Laporan Riwayat Konsultasi</h2>
        <div class="table-responsive">
            <table class="table table-hover align-middle data-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Bahan</th>
                        <th>Resep</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultations as $consultation): ?>
                        <tr>
                            <td><?= e(format_date($consultation['tanggal'])) ?></td>
                            <td><?= e($consultation['nama']) ?></td>
                            <td><?= e($consultation['email']) ?></td>
                            <td><?= e((string) $consultation['ingredient_total']) ?></td>
                            <td><?= e((string) $consultation['recipe_total']) ?></td>
                            <td><a href="<?= route_url('consultation/detail&id=' . $consultation['id']) ?>" class="btn btn-sm btn-outline-primary">Detail</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
