<div class="auth-card">
    <div class="auth-hero">
        <div class="auth-logo">CF</div>
        <h1>Craft Food Finder</h1>
        <p>Sistem pakar resep makanan berbasis Forward Chaining.</p>
    </div>
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <h2 class="h4 fw-bold mb-3">Login</h2>
            <p class="text-muted mb-4">Masuk untuk memulai konsultasi resep.</p>
            <form method="POST" action="<?= route_url('auth/login') ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg" value="<?= e(old('email')) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" required>
                </div>
                <button class="btn btn-primary btn-lg w-100 mb-3" type="submit">Masuk</button>
            </form>
            <div class="text-center">
                <span class="text-muted">Belum punya akun?</span>
                <a href="<?= route_url('auth/register') ?>">Daftar sekarang</a>
            </div>
        </div>
    </div>
</div>
