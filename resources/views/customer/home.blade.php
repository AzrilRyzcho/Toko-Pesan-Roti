@extends('layouts.app')

@section('content')
<!-- Hero Section with Staggered Entrance & Floating Image -->
<div class="container py-4 my-3">
    <div class="row align-items-center gy-4">
        <!-- Left Hero Text -->
        <div class="col-lg-6">
            <div class="animate-fade-in-up animate-delay-1 mb-3">
                <span class="badge text-dark fw-semibold py-2 px-3 rounded-pill badge-pulse" style="background-color: #F3EBDD; color: #593E22 !important; font-size: 0.78rem;">
                    <i class="fa-solid fa-fire me-1 text-caramel"></i> Diskon 20% Hari Ini
                </span>
            </div>
            
            <h1 class="font-serif fw-bold display-5 text-primary mb-3 animate-fade-in-up animate-delay-2" style="line-height: 1.25;">
                Kehangatan di Setiap Gigitan.
            </h1>

            <p class="text-muted small mb-4 col-lg-10 animate-fade-in-up animate-delay-3" style="line-height: 1.8; font-size: 0.92rem;">
                Roti segar panggang dari oven setiap pagi, dibuat dengan 100% bahan-bahan alami dan resep tradisional untuk menemani kehangatan hari Anda.
            </p>

            <div class="d-flex flex-wrap gap-3 animate-fade-in-up animate-delay-4">
                <a href="{{ route('shop') }}" class="btn btn-caramel px-4 py-2.5 text-decoration-none btn-hover-bounce">
                    <i class="fa-solid fa-cart-shopping me-1.5"></i> Pesan Sekarang
                </a>
                <a href="{{ route('shop') }}" class="btn btn-caramel-outline px-4 py-2.5 text-decoration-none btn-hover-bounce">
                    <i class="fa-solid fa-utensils me-1.5"></i> Lihat Menu
                </a>
            </div>
        </div>

        <!-- Right Hero Image with Floating Animation -->
        <div class="col-lg-6">
            <div class="p-1 animate-fade-in-up animate-delay-2">
                <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=900" alt="Roti Segar Oven" class="img-fluid rounded-4 shadow-sm w-100 floating-hero-img" style="height: 390px; object-fit: cover;">
            </div>
        </div>
    </div>
</div>

<!-- Bakery Value Features Row -->
<div class="container py-4 my-2">
    <div class="row g-3">
        <div class="col-6 col-md-3">
            <div class="feature-badge-card d-flex align-items-center gap-3">
                <div class="rounded-circle p-2 bg-bakery-cream text-caramel d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                    <i class="fa-solid fa-wheat-awn fs-5"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-primary mb-0" style="font-size: 0.85rem;">100% Bahan Alami</h6>
                    <span class="text-muted small" style="font-size: 0.72rem;">Bebas Pengawet</span>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="feature-badge-card d-flex align-items-center gap-3">
                <div class="rounded-circle p-2 bg-bakery-cream text-caramel d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                    <i class="fa-solid fa-fire-burner fs-5"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-primary mb-0" style="font-size: 0.85rem;">Fresh From Oven</h6>
                    <span class="text-muted small" style="font-size: 0.72rem;">Dipanggang Setiap Pagi</span>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="feature-badge-card d-flex align-items-center gap-3">
                <div class="rounded-circle p-2 bg-bakery-cream text-caramel d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                    <i class="fa-solid fa-truck-fast fs-5"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-primary mb-0" style="font-size: 0.85rem;">Pengiriman Cepat</h6>
                    <span class="text-muted small" style="font-size: 0.72rem;">Sampai Hari Ini</span>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="feature-badge-card d-flex align-items-center gap-3">
                <div class="rounded-circle p-2 bg-bakery-cream text-caramel d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                    <i class="fa-solid fa-award fs-5"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-primary mb-0" style="font-size: 0.85rem;">Kualitas Artisan</h6>
                    <span class="text-muted small" style="font-size: 0.72rem;">Resep Otentik</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section: Jelajahi Rasa (Category Cards with Smooth Hover Animations) -->
<div class="container py-4 mb-5" id="tentang-kami">
    <div class="text-center mb-4">
        <h3 class="font-serif fw-bold text-primary mb-1">Jelajahi Rasa</h3>
        <p class="text-muted small mb-0">Pilihan varian roti dan kue terbaik kami yang dipanggang dengan cinta.</p>
    </div>

    <!-- Category Cards Row (3 Cards with Hover Zoom & Floating Content) -->
    <div class="row g-4 justify-content-center">
        <!-- Card 1: Roti Manis -->
        <div class="col-md-4">
            <a href="{{ route('shop', ['category' => 'artisan-bread']) }}" class="text-decoration-none d-block">
                <div class="category-card-overlay">
                    <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=600" alt="Roti Manis">
                    <div class="overlay-content">
                        <h4 class="category-title">Roti Manis</h4>
                        <span>Lihat Pilihan <i class="fa-solid fa-arrow-right ms-1" style="font-size: 0.75rem;"></i></span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 2: Roti Tawar -->
        <div class="col-md-4">
            <a href="{{ route('shop', ['category' => 'french-pastries']) }}" class="text-decoration-none d-block">
                <div class="category-card-overlay">
                    <img src="https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=600" alt="Roti Tawar">
                    <div class="overlay-content">
                        <h4 class="category-title">Roti Tawar</h4>
                        <span>Lihat Pilihan <i class="fa-solid fa-arrow-right ms-1" style="font-size: 0.75rem;"></i></span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 3: Kue Premium -->
        <div class="col-md-4">
            <a href="{{ route('shop', ['category' => 'premium-cakes']) }}" class="text-decoration-none d-block">
                <div class="category-card-overlay">
                    <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&q=80&w=600" alt="Kue Premium">
                    <div class="overlay-content">
                        <h4 class="category-title">Kue Premium</h4>
                        <span>Lihat Pilihan <i class="fa-solid fa-arrow-right ms-1" style="font-size: 0.75rem;"></i></span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
