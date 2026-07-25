<x-guest-layout>
<div class="container d-flex flex-column align-items-center justify-content-center min-vh-100 py-5">
    <div class="card card-figma border-0 shadow-lg p-4 p-md-5 w-100" style="max-width: 460px;">
        @if (session('status'))
            <!-- Success Sent State (Figma Image 3 Bottom Card) -->
            <div class="text-center py-2">
                <div class="rounded-circle bg-bakery-cream d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                    <i class="fa-solid fa-paper-plane text-caramel fs-3"></i>
                </div>
                <h4 class="font-serif fw-bold text-primary mb-2">Tautan Reset Terkirim</h4>
                <p class="text-muted small mb-4" style="font-size: 0.85rem; line-height: 1.6;">
                    Kami telah mengirimkan instruksi pemulihan kata sandi ke alamat email Anda. Silakan periksa kotak masuk atau folder spam Anda.
                </p>

                <a href="{{ route('login') }}" class="btn btn-caramel w-100 py-3 text-uppercase font-serif text-decoration-none d-block mb-3 fs-7">
                    KEMBALI KE LOGIN
                </a>

                <div class="text-muted small font-serif mt-2 opacity-75">Toko Pesan Roti</div>
            </div>
        @else
            <!-- Form State (Figma Image 3 Top Card) -->
            <div class="text-center mb-4">
                <h3 class="font-serif fw-bold text-primary mb-2">Lupa Password</h3>
                <p class="text-muted small" style="font-size: 0.82rem; line-height: 1.6;">
                    Masukkan email yang terdaftar pada akun Anda. Kami akan mengirimkan tautan untuk mengatur ulang password.
                </p>
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold text-primary small">Email Anda</label>
                    <div class="input-icon-group">
                        <i class="fa-regular fa-envelope input-icon-start"></i>
                        <input id="email" class="form-control form-control-figma @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus />
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-caramel w-100 py-3 mb-3">
                    Kirim Tautan Reset
                </button>

                <div class="text-center">
                    <span class="small text-muted" style="font-size: 0.82rem;">Ingat password Anda? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Kembali ke Login</a></span>
                </div>
            </form>
        @endif
    </div>
</div>
</x-guest-layout>
