@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <!-- Left Sidebar Card -->
        <div class="col-lg-3">
            <div class="card card-figma border-0 p-4 shadow-sm text-center mb-4">
                @php
                    $user = auth()->user();
                    $avatar = $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=200';
                @endphp
                <img src="{{ $avatar }}" class="rounded-circle mx-auto mb-3 border border-light" alt="Avatar" style="width: 72px; height: 72px; object-fit: cover;">
                <h6 class="font-serif fw-bold text-primary mb-0">{{ $user->name }}</h6>
                <span class="text-muted small d-block mb-3" style="font-size: 0.75rem;">Member sejak {{ $user->created_at->format('Y') }}</span>

                <!-- Navigation List -->
                <div class="d-flex flex-column gap-1 text-start">
                    <a href="{{ route('profile.edit') }}" class="profile-nav-link">
                        <i class="fa-regular fa-user me-2"></i> Profil Saya
                    </a>
                    <a href="{{ route('orders.index') }}" class="profile-nav-link">
                        <i class="fa-solid fa-clock-rotate-left me-2"></i> Riwayat Pesanan
                    </a>
                    <a href="{{ route('favorites.index') }}" class="profile-nav-link active">
                        <i class="fa-solid fa-heart me-2 text-danger"></i> Favorit
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="profile-nav-link border-0 bg-transparent w-100 text-danger text-start">
                            <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-lg-9">
            <div class="card card-figma border-0 p-4 p-md-5 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-light pb-3">
                    <div>
                        <h4 class="font-serif fw-bold text-primary mb-1">Produk Favorit Saya</h4>
                        <p class="text-muted small mb-0">Daftar roti dan kue pilihan yang Anda simpan.</p>
                    </div>
                    <span class="badge bg-bakery-cream text-primary border border-secondary-subtle px-3 py-2 fw-semibold">
                        {{ $favorites->count() }} Produk
                    </span>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show small py-2 px-3 mb-3 rounded-3" role="alert">
                        <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($favorites->isEmpty())
                    <div class="text-center py-5">
                        <i class="fa-regular fa-heart text-muted mb-3" style="font-size: 3rem; opacity: 0.4;"></i>
                        <h5 class="font-serif fw-bold text-primary mb-1">Belum Ada Favorit</h5>
                        <p class="text-muted small mb-4">Anda belum menyimpan produk favorit apapun.</p>
                        <a href="{{ route('shop') }}" class="btn btn-caramel px-4 py-2">
                            <i class="fa-solid fa-store me-1"></i> Jelajahi Katalog Roti
                        </a>
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($favorites as $fav)
                            @php
                                $product = $fav->product;
                            @endphp
                            @if($product)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card card-figma h-100 border-0 shadow-sm overflow-hidden position-relative">
                                        <!-- Remove Favorite Button -->
                                        <form action="{{ route('favorites.toggle', $product->id) }}" method="POST" class="position-absolute top-0 end-0 m-2 z-2">
                                            @csrf
                                            <button type="submit" class="btn btn-white bg-white rounded-circle p-2 shadow-sm border-0 text-danger" title="Hapus dari favorit">
                                                <i class="fa-solid fa-heart"></i>
                                            </button>
                                        </form>

                                        <div style="height: 180px; overflow: hidden;">
                                            @php
                                                if (str_starts_with($product->image ?? '', 'http')) {
                                                    $imgSrc = $product->image;
                                                } elseif ($product->image) {
                                                    $imgSrc = str_starts_with($product->image, 'images/') ? asset($product->image) : asset('storage/' . $product->image);
                                                } else {
                                                    $imgSrc = 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=400';
                                                }
                                            @endphp
                                            <img src="{{ $imgSrc }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $product->name }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800';">
                                        </div>

                                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                                            <div>
                                                <span class="badge text-uppercase mb-1" style="background-color: #FAF6ED; color: #8C6B47; font-size: 0.65rem;">
                                                    {{ $product->category->name ?? 'Roti' }}
                                                </span>
                                                <h6 class="font-serif fw-bold text-primary mb-1">{{ $product->name }}</h6>
                                                <p class="text-muted small mb-2" style="font-size: 0.78rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                    {{ $product->description }}
                                                </p>
                                            </div>

                                            <div class="pt-2 border-top border-light d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-caramel fs-6">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                <a href="{{ route('shop') }}" class="btn btn-caramel-outline btn-sm px-3 py-1 text-decoration-none">
                                                    Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
