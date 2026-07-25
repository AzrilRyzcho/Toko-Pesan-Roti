<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Toko Pesan Roti') }} - Kehangatan di Setiap Gigitan</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Toko Pesan Roti - Menyajikan roti artisan segar, pastry renyah, dan kue manis buatan tangan setiap hari.">

    <!-- Scripts & Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    @unless(View::hasSection('hide_navbar'))
    <!-- Top Figma Navigation Bar -->
    <nav class="navbar navbar-expand-lg bg-bakery-cream py-3 border-bottom border-light sticky-top">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <span class="font-serif fw-bold fs-3 text-primary">Toko Pesan Roti</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarFigma" aria-controls="navbarFigma" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars text-primary fs-4"></i>
            </button>

            <!-- Center Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarFigma">
                <ul class="navbar-nav mx-auto align-items-center gap-2 gap-lg-4 my-2 my-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-medium text-primary {{ request()->routeIs('home') ? 'active border-bottom border-2 border-warning text-dark' : 'opacity-75' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium text-primary {{ request()->routeIs('shop*') ? 'active border-bottom border-2 border-warning text-dark' : 'opacity-75' }}" href="{{ route('shop') }}">Katalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium text-primary opacity-75" href="{{ route('home') }}#tentang-kami">Tentang Kami</a>
                    </li>
                </ul>

                <!-- Right Action Icons / Auth -->
                <div class="d-flex align-items-center gap-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-caramel btn-sm py-2 px-3">
                                <i class="fa-solid fa-gauge me-1"></i> Admin Panel
                            </a>
                        @else
                            <a href="{{ route('orders.index') }}" class="text-primary text-decoration-none small fw-semibold me-2">
                                <i class="fa-solid fa-clock-rotate-left me-1"></i> Pesanan Saya
                            </a>
                        @endif

                        <!-- Cart Icon -->
                        <a href="{{ route('cart.index') }}" class="text-primary position-relative fs-5 text-decoration-none">
                            <i class="fa-solid fa-cart-shopping"></i>
                            @php
                                $cartCount = auth()->user()->cart ? auth()->user()->cart->items->sum('quantity') : 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <!-- User Profile Dropdown -->
                        <div class="dropdown">
                            <a href="#" class="text-primary text-decoration-none dropdown-toggle d-flex align-items-center" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-user fs-5 me-1"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2" aria-labelledby="userMenu">
                                <li class="px-3 py-2 border-bottom">
                                    <span class="d-block fw-bold small text-primary">{{ auth()->user()->name }}</span>
                                    <span class="d-block text-muted" style="font-size: 0.75rem;">{{ auth()->user()->email }}</span>
                                </li>
                                <li><a class="dropdown-item small py-2" href="{{ route('profile.edit') }}"><i class="fa-solid fa-user me-2 text-muted"></i> Profile</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item small py-2 text-danger" type="submit"><i class="fa-solid fa-sign-out-alt me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-primary text-decoration-none fs-5 me-1" title="Masuk">
                            <i class="fa-regular fa-user"></i>
                        </a>
                        <a href="{{ route('cart.index') }}" class="text-primary fs-5 text-decoration-none" title="Keranjang">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-caramel btn-sm px-3 py-2 ms-2">Masuk</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    @endunless

    <!-- Page Body -->
    <main>
        @yield('content')
    </main>

    @unless(View::hasSection('hide_footer'))
    <!-- Figma Footer -->
    <footer class="bg-bakery-footer py-5 mt-5 border-top border-light">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-6">
                    <h5 class="font-serif fw-bold text-primary mb-2">Toko Pesan Roti</h5>
                    <p class="text-muted small mb-0" style="max-width: 380px; line-height: 1.7;">
                        Kehangatan di Setiap Gigitan. Menyajikan roti segar setiap hari untuk lingkungan kami tercinta.
                    </p>
                </div>
                <div class="col-md-6 text-md-end d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-md-end gap-4 text-muted small">
                        <a href="{{ route('home') }}" class="text-decoration-none text-muted">Beranda</a>
                        <a href="{{ route('shop') }}" class="text-decoration-none text-muted">Katalog</a>
                        <a href="{{ route('home') }}#tentang-kami" class="text-decoration-none text-muted">Tentang Kami</a>
                    </div>
                </div>
            </div>
            <div class="border-top border-secondary opacity-15 my-4"></div>
            <div class="text-muted small" style="font-size: 0.78rem;">
                &copy; {{ date('Y') }} Toko Pesan Roti. Kehangatan di Setiap Gigitan.
            </div>
        </div>
    </footer>
    @endunless

    <!-- Bootstrap & SweetAlert Integration -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                window.showAlert('Berhasil', "{{ session('success') }}", 'success');
            @endif

            @if(session('error'))
                window.showAlert('Gagal', "{{ session('error') }}", 'error');
            @endif

            @if(session('info'))
                window.showAlert('Informasi', "{{ session('info') }}", 'info');
            @endif
        });
    </script>
</body>
</html>
