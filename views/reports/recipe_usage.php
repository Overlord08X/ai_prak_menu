<div class="card shadow-sm border-0">
    <div class="card-body">
        <h2 class="h4 fw-bold mb-3">Statistik Penggunaan Resep</h2>
        <div class="table-responsive">
            <table class="table table-hover align-middle data-table">
                <thead>
                    <tr>
                        <th>Resep</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Digunakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recipeStats as $recipe): ?>
                        <tr>
                            <td class="fw-semibold"><?= e($recipe['nama_resep']) ?></td>
                            <td><?= e($recipe['deskripsi'] ?: '-') ?></td>
                            <td><?= e((string) $recipe['usage_total']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
