<x-guest-layout>
<div class="auth-split-wrapper">
    <!-- Left Hero Image Column (Matching User Reference Image) -->
    <div class="auth-left-image d-none d-lg-flex">
        <h1 class="auth-brand-title">Toko Pesan Roti</h1>
        <p class="auth-brand-desc">
            Kehangatan di setiap gigitan. Bergabunglah dengan kami untuk menikmati roti artisan segar setiap hari, dibuat dengan cinta dan bahan alami.
        </p>
    </div>

    <!-- Right Form Column -->
    <div class="auth-right-form">
        <div class="auth-form-inner">
            <div class="mb-4">
                <h2 class="font-serif fw-bold text-primary mb-1" style="font-size: 1.85rem;">Selamat Datang Kembali</h2>
                <p class="text-muted small" style="font-size: 0.85rem;">Masuk ke akun Anda untuk mulai memesan roti favorit.</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success small py-2 mb-3" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold text-primary small">Email</label>
                    <div class="input-icon-group">
                        <i class="fa-regular fa-envelope input-icon-start"></i>
                        <input id="email" class="form-control form-control-figma @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus autocomplete="username" />
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="form-label fw-semibold text-primary small mb-0">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-muted small text-decoration-none" style="font-size: 0.75rem;">Lupa Password?</a>
                        @endif
                    </div>
                    <div class="input-icon-group">
                        <i class="fa-solid fa-lock input-icon-start"></i>
                        <input id="password" class="form-control form-control-figma @error('password') is-invalid @enderror" type="password" name="password" placeholder="••••••••" required autocomplete="current-password" />
                        <i class="fa-regular fa-eye input-icon-end" onclick="togglePass('password', this)"></i>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-caramel w-100 py-3 mt-2 mb-3">
                    Masuk <i class="fa-solid fa-arrow-right ms-2 fs-6"></i>
                </button>

                <div class="text-center mt-2">
                    <span class="small text-muted" style="font-size: 0.85rem;">Belum punya akun? <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Daftar Sekarang</a></span>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePass(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
</x-guest-layout>
