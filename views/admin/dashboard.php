<div class="dashboard-hero mb-4">
    <div>
        <span class="badge text-bg-light mb-3">Admin Dashboard</span>
        <h2 class="display-6 fw-bold mb-2">Selamat datang, <?= e(auth_user()['nama'] ?? 'Admin') ?></h2>
        <p class="text-white-50 mb-0">Pantau pengguna, resep, bahan, rule, dan konsultasi dalam satu tampilan.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <?php $cards = [
        ['label' => 'Total User', 'value' => $totalUsers, 'icon' => 'bi-people'],
        ['label' => 'Total Resep', 'value' => $totalRecipes, 'icon' => 'bi-journal-text'],
        ['label' => 'Total Bahan', 'value' => $totalIngredients, 'icon' => 'bi-basket2'],
        ['label' => 'Total Rule', 'value' => $totalRules, 'icon' => 'bi-diagram-3'],
        ['label' => 'Total Konsultasi', 'value' => $totalConsultations, 'icon' => 'bi-receipt'],
    ]; foreach ($cards as $card): ?>
        <div class="col-12 col-md-6 col-xl-4">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi <?= e($card['icon']) ?>"></i></div>
                <div>
                    <div class="stat-label"><?= e($card['label']) ?></div>
                    <div class="stat-value"><?= e((string) $card['value']) ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row g-4">
    <div class="col-12 col-xl-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h3 class="h5 fw-bold mb-3">Konsultasi Terbaru</h3>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Pengguna</th>
                                <th>Tanggal</th>
                                <th>Hasil</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentConsultations as $item): ?>
                                <tr>
                                    <td><?= e($item['nama']) ?></td>
                                    <td><?= e(format_date($item['tanggal'])) ?></td>
                                    <td><?= e((string) $item['recipe_total']) ?> resep</td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if ($recentConsultations === []): ?>
                                <tr><td colspan="3" class="text-muted">Belum ada konsultasi.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h3 class="h5 fw-bold mb-3">Resep Paling Sering Dipakai</h3>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Resep</th>
                                <th>Terpakai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recipeStats as $item): ?>
                                <tr>
                                    <td><?= e($item['nama_resep']) ?></td>
                                    <td><?= e((string) $item['usage_total']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if ($recipeStats === []): ?>
                                <tr><td colspan="2" class="text-muted">Belum ada data.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
