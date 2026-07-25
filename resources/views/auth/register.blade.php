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
                <h2 class="font-serif fw-bold text-primary mb-1" style="font-size: 1.85rem;">Buat Akun Baru</h2>
                <p class="text-muted small" style="font-size: 0.85rem;">Lengkapi data diri Anda untuk mulai memesan roti favorit.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold text-primary small">Nama Lengkap</label>
                    <div class="input-icon-group">
                        <i class="fa-regular fa-user input-icon-start"></i>
                        <input id="name" class="form-control form-control-figma @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap Anda" required autofocus />
                    </div>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold text-primary small">Email</label>
                    <div class="input-icon-group">
                        <i class="fa-regular fa-envelope input-icon-start"></i>
                        <input id="email" class="form-control form-control-figma @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required />
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- No. Telepon -->
                <div class="mb-3">
                    <label for="phone" class="form-label fw-semibold text-primary small">No. Telepon</label>
                    <div class="input-icon-group">
                        <i class="fa-solid fa-phone input-icon-start"></i>
                        <input id="phone" class="form-control form-control-figma @error('phone') is-invalid @enderror" type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" />
                    </div>
                    @error('phone')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold text-primary small">Password</label>
                    <div class="input-icon-group">
                        <i class="fa-solid fa-lock input-icon-start"></i>
                        <input id="password" class="form-control form-control-figma @error('password') is-invalid @enderror" type="password" name="password" placeholder="Minimal 8 karakter" required />
                        <i class="fa-regular fa-eye input-icon-end" onclick="togglePass('password', this)"></i>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-semibold text-primary small">Konfirmasi Password</label>
                    <div class="input-icon-group">
                        <i class="fa-solid fa-shield-halved input-icon-start"></i>
                        <input id="password_confirmation" class="form-control form-control-figma @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" placeholder="Ulangi password Anda" required />
                        <i class="fa-regular fa-eye input-icon-end" onclick="togglePass('password_confirmation', this)"></i>
                    </div>
                    @error('password_confirmation')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Agreement Checkbox -->
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="terms" required checked>
                    <label class="form-check-label text-muted small" for="terms" style="font-size: 0.78rem;">
                        Saya setuju dengan <a href="#" class="text-primary text-decoration-none fw-semibold">Syarat & Ketentuan</a> dan <a href="#" class="text-primary text-decoration-none fw-semibold">Kebijakan Privasi</a>.
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-caramel w-100 py-3 mb-3">
                    Daftar Sekarang <i class="fa-solid fa-arrow-right ms-2 fs-6"></i>
                </button>

                <div class="text-center mt-3">
                    <span class="small text-muted" style="font-size: 0.85rem;">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Masuk di sini</a></span>
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
