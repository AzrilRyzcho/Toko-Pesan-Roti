@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Header Title & Category Pill Filters -->
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-5 animate-fade-in-up animate-delay-1">
        <div>
            <h2 class="font-serif fw-bold text-primary mb-1">Katalog Produk</h2>
            <p class="text-muted small mb-0">Temukan berbagai pilihan roti segar yang dipanggang setiap hari.</p>
        </div>

        <!-- Filter Pill Buttons Wrapper (Responsive Flex Wrap on Desktop + Arrow Controls on Mobile) -->
        <div class="category-filter-wrapper">
            <button class="scroll-arrow-btn d-lg-none" id="scrollLeftBtn" title="Geser Kiri">
                <i class="fa-solid fa-chevron-left" style="font-size: 0.75rem;"></i>
            </button>

            <div class="category-filter-scroll" id="categoryScrollContainer">
                <a href="{{ route('shop') }}" class="btn-pill-filter {{ !request('category') ? 'active' : '' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="btn-pill-filter {{ request('category') === $cat->slug ? 'active' : '' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <button class="scroll-arrow-btn d-lg-none" id="scrollRightBtn" title="Geser Kanan">
                <i class="fa-solid fa-chevron-right" style="font-size: 0.75rem;"></i>
            </button>
        </div>
    </div>

    <!-- Product Grid 4-Columns (100% Figma Match with Smooth Hover & Entrance Animations) -->
    @if($products->isEmpty())
        <div class="card card-figma p-5 text-center my-4 animate-fade-in-up animate-delay-2">
            <i class="fa-solid fa-cookie text-caramel fs-1 mb-3"></i>
            <h4 class="font-serif fw-bold text-primary">Tidak Ada Produk</h4>
            <p class="text-muted small">Maaf, belum ada produk untuk kategori yang dipilih saat ini.</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($products as $index => $prod)
                @php
                    $delayClass = 'animate-delay-' . (($index % 4) + 1);
                @endphp
                <div class="col-lg-3 col-md-6 animate-fade-in-up {{ $delayClass }}">
                    <div class="catalog-item-figma h-100 d-flex flex-column justify-content-between">
                        <div>
                            <!-- Image Box with Floating Best Seller Badge & Favorite Button -->
                            <div class="catalog-image-box mb-1 position-relative">
                                @if($index === 1 || $prod->name === 'Roti Tawar Susu Premium')
                                    <span class="catalog-bestseller-badge">Best Seller</span>
                                @endif

                                @auth
                                    @php
                                        $isFav = auth()->user()->favorites()->where('product_id', $prod->id)->exists();
                                    @endphp
                                    <form action="{{ route('favorites.toggle', $prod->id) }}" method="POST" class="position-absolute top-0 end-0 m-2 z-2">
                                        @csrf
                                        <button type="submit" class="btn btn-white bg-white rounded-circle p-2 shadow-sm border-0 {{ $isFav ? 'text-danger' : 'text-muted' }}" title="{{ $isFav ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}">
                                            <i class="fa-solid fa-heart"></i>
                                        </button>
                                    </form>
                                @endauth

                                @php
                                    if (str_starts_with($prod->image ?? '', 'http')) {
                                        $imgUrl = $prod->image;
                                    } elseif ($prod->image) {
                                        $imgUrl = str_starts_with($prod->image, 'images/') ? asset($prod->image) : asset('storage/' . $prod->image);
                                    } else {
                                        $imgUrl = 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=400';
                                    }
                                @endphp
                                <img src="{{ $imgUrl }}" alt="{{ $prod->name }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800';">
                            </div>

                            <!-- Category Pill Tag -->
                            <span class="catalog-category-pill">
                                {{ $prod->category->name ?? 'Kategori' }}
                            </span>

                            <!-- Product Title -->
                            <h6 class="catalog-item-title">{{ $prod->name }}</h6>

                            <!-- Product Price -->
                            <div class="catalog-item-price">
                                Rp {{ number_format($prod->price, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Button "Lihat Detail" -->
                        <div>
                            <a href="{{ route('shop.show', $prod->slug) }}" class="btn-caramel-outline w-100 text-decoration-none text-center d-block btn-hover-bounce">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Custom Bakery Pagination -->
        @if($products->hasPages())
            <div class="d-flex justify-content-center mt-5 animate-fade-in-up">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        @endif
    @endif
</div>

<!-- Category Filter Scroll JS -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('categoryScrollContainer');
        const leftBtn = document.getElementById('scrollLeftBtn');
        const rightBtn = document.getElementById('scrollRightBtn');

        if (container && leftBtn && rightBtn) {
            leftBtn.addEventListener('click', function () {
                container.scrollBy({ left: -220, behavior: 'smooth' });
            });

            rightBtn.addEventListener('click', function () {
                container.scrollBy({ left: 220, behavior: 'smooth' });
            });

            // Convert mouse wheel vertical scroll to horizontal scroll
            container.addEventListener('wheel', function (e) {
                if (e.deltaY !== 0) {
                    e.preventDefault();
                    container.scrollLeft += e.deltaY;
                }
            });
        }
    });
</script>
@endsection
