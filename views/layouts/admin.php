<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? config('app_name')) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="<?= asset_url('css/style.css') ?>" rel="stylesheet">
</head>
<body class="admin-body">
<div class="admin-shell">
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <div class="brand-badge">CF</div>
            <div>
                <div class="brand-title"><?= e(config('app_name')) ?></div>
                <small>Sistem Pakar</small>
            </div>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= route_url('dashboard/admin') ?>" class="nav-link"><i class="bi bi-grid-1x2"></i> Dashboard</a>
            <a href="<?= route_url('ingredient/index') ?>" class="nav-link"><i class="bi bi-basket2"></i> Bahan</a>
            <a href="<?= route_url('recipe/index') ?>" class="nav-link"><i class="bi bi-journal-text"></i> Resep</a>
            <a href="<?= route_url('rule/index') ?>" class="nav-link"><i class="bi bi-diagram-3"></i> Rule</a>
            <a href="<?= route_url('user/index') ?>" class="nav-link"><i class="bi bi-people"></i> User</a>
            <a href="<?= route_url('report/consultations') ?>" class="nav-link"><i class="bi bi-receipt"></i> Laporan Konsultasi</a>
            <a href="<?= route_url('report/recipeUsage') ?>" class="nav-link"><i class="bi bi-bar-chart"></i> Statistik Resep</a>
            <a href="<?= route_url('consultation/form') ?>" class="nav-link"><i class="bi bi-magic"></i> Konsultasi</a>
            <a href="<?= route_url('consultation/history') ?>" class="nav-link"><i class="bi bi-clock-history"></i> Riwayat</a>
            <a href="<?= route_url('auth/logout') ?>" class="nav-link text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </nav>
    </aside>
    <div class="admin-main">
        <header class="admin-topbar">
            <div>
                <h1 class="page-title mb-0"><?= e($title ?? 'Dashboard') ?></h1>
                <p class="text-muted mb-0">Craft Food Finder - Native PHP MVC</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end">
                    <div class="fw-semibold"><?= e(auth_user()['nama'] ?? 'Admin') ?></div>
                    <small class="text-muted">Admin Panel</small>
                </div>
                <div class="avatar-circle"><?= strtoupper(substr((string) (auth_user()['nama'] ?? 'A'), 0, 1)) ?></div>
            </div>
        </header>
        <section class="content-wrap container-fluid py-4">
            <?php require __DIR__ . '/../partials/flash.php'; ?>
            <?= $content ?>
        </section>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= asset_url('js/app.js') ?>"></script>
</body>
</html>
