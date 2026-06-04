<div class="user-hero mb-4">
    <div>
        <span class="badge text-bg-dark mb-3">User Dashboard</span>
        <h2 class="display-6 fw-bold mb-2">Halo, <?= e($user['nama'] ?? 'Pengguna') ?></h2>
        <p class="text-white-50 mb-0">Pilih bahan yang tersedia dan temukan resep yang paling cocok.</p>
    </div>
    <div class="text-end d-none d-md-block">
        <div class="hero-stat"><?= e((string) $totalConsultations) ?></div>
        <small>Konsultasi Tersimpan</small>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-receipt"></i></div>
            <div>
                <div class="stat-label">Konsultasi Saya</div>
                <div class="stat-value"><?= e((string) $totalConsultations) ?></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-journal-text"></i></div>
            <div>
                <div class="stat-label">Total Resep</div>
                <div class="stat-value"><?= e((string) $totalRecipes) ?></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-basket2"></i></div>
            <div>
                <div class="stat-label">Total Bahan</div>
                <div class="stat-value"><?= e((string) $totalIngredients) ?></div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <h3 class="h5 fw-bold mb-3">Riwayat Terakhir</h3>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Bahan Dipilih</th>
                        <th>Hasil Resep</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($latestHistory as $item): ?>
                        <tr>
                            <td><?= e(format_date($item['tanggal'])) ?></td>
                            <td><?= e((string) $item['ingredient_total']) ?></td>
                            <td><?= e((string) $item['recipe_total']) ?></td>
                            <td><a href="<?= route_url('consultation/detail&id=' . $item['id']) ?>" class="btn btn-sm btn-outline-primary">Detail</a></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($latestHistory === []): ?>
                        <tr><td colspan="4" class="text-muted">Belum ada riwayat konsultasi.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
