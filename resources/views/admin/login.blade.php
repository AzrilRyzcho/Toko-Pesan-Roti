<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Portal - Toko Pesan Roti</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-bakery-cream min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="card card-figma border-0 shadow-lg p-0 overflow-hidden w-100" style="max-width: 880px;">
        <div class="row g-0">
            <!-- Left Side: Bakery Image Overlay (Figma Screenshot 1) -->
            <div class="col-md-6 position-relative d-none d-md-block" style="min-height: 480px;">
                <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800" class="w-100 h-100" style="object-fit: cover;" alt="Toko Pesan Roti Admin">
                <div class="position-absolute top-0 start-0 w-100 h-100 p-5 d-flex flex-column justify-content-end text-white" style="background: linear-gradient(to top, rgba(74,51,25,0.92) 0%, rgba(74,51,25,0.3) 100%);">
                    <h2 class="font-serif fw-bold mb-2 fs-2 text-white">Toko Pesan Roti</h2>
                    <p class="small opacity-85 mb-0" style="line-height: 1.6; max-width: 320px;">
                        Kehangatan di Setiap Gigitan. Sistem Manajemen Internal.
                    </p>
                </div>
            </div>

            <!-- Right Side: Admin Portal Login Form (Figma Screenshot 1) -->
            <div class="col-md-6 p-4 p-lg-5 bg-white d-flex flex-column justify-content-center">
                <div class="mb-4">
                    <span class="badge text-uppercase fw-bold mb-2 py-1.5 px-3" style="background-color: #F3EBDD; color: #593E22; font-size: 0.68rem; letter-spacing: 0.8px;">
                        ADMIN PORTAL
                    </span>
                    <h3 class="font-serif fw-bold text-primary mb-1">Selamat Datang Kembali</h3>
                    <p class="text-muted small mb-0" style="font-size: 0.82rem;">Silakan masuk dengan kredensial administrator Anda.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold text-primary small">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-bakery-cream border-secondary-subtle text-muted">
                                <i class="fa-regular fa-envelope"></i>
                            </span>
                            <input type="email" id="email" name="email" class="form-control form-control-figma" placeholder="admin@tokopesanroti.com" value="{{ old('email') }}" required autofocus>
                        </div>
                        @error('email')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold text-primary small">Kata Sandi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-bakery-cream border-secondary-subtle text-muted">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" id="password" name="password" class="form-control form-control-figma" placeholder="••••••••" required>
                            <button class="btn btn-outline-secondary border-secondary-subtle bg-white" type="button" onclick="const p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password';">
                                <i class="fa-regular fa-eye text-muted"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                            <label class="form-check-label text-muted small" for="remember_me">Ingat saya</label>
                        </div>
                        <a href="#" class="text-caramel small text-decoration-none fw-bold" style="font-size: 0.78rem;">Lupa Password Admin?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-caramel w-100 py-3 mb-4">
                        Masuk sebagai Admin <i class="fa-solid fa-arrow-right ms-1"></i>
                    </button>
                </form>

                <div class="text-center text-muted small" style="font-size: 0.72rem;">
                    Akses sistem dilindungi. Percobaan masuk tidak sah akan dicatat.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
