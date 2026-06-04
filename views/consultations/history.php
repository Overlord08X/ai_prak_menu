<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Riwayat Konsultasi</h2>
        <p class="text-muted mb-0">Daftar konsultasi yang pernah Anda lakukan.</p>
    </div>
    <a href="<?= route_url('consultation/form') ?>" class="btn btn-primary">Konsultasi Baru</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle data-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Bahan</th>
                        <th>Hasil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultations as $consultation): ?>
                        <tr>
                            <td><?= e(format_date($consultation['tanggal'])) ?></td>
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
