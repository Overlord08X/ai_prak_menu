<div class="auth-card">
    <div class="auth-hero">
        <div class="auth-logo">CF</div>
        <h1>Buat Akun</h1>
        <p>Registrasi untuk menyimpan riwayat konsultasi Anda.</p>
    </div>
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <h2 class="h4 fw-bold mb-3">Register</h2>
            <form method="POST" action="<?= route_url('auth/register') ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= e(old('nama')) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= e(old('email')) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100 mb-3" type="submit">Daftar</button>
            </form>
            <div class="text-center">
                <span class="text-muted">Sudah punya akun?</span>
                <a href="<?= route_url('auth/login') ?>">Login</a>
            </div>
        </div>
    </div>
</div>
