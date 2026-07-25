@extends('layouts.app')

@section('hide_navbar', true)

@section('content')
<div class="container py-4">
    <!-- Top Header Row matching Figma Screenshot 1 -->
    <div class="position-relative d-flex align-items-center justify-content-center mb-4 pt-2">
        <a href="{{ route('shop') }}" class="position-absolute start-0 text-muted small text-decoration-none">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali Belanja
        </a>
        <h2 class="font-serif fw-bold text-primary mb-0 text-center">Toko Pesan Roti</h2>
    </div>

    <!-- Main Heading -->
    <div class="mb-4">
        <h3 class="font-serif fw-bold text-primary mb-1">Keranjang Belanja</h3>
        <p class="text-muted small mb-0">Anda memiliki {{ $totalItems }} produk dalam keranjang.</p>
    </div>

    @if($items->isEmpty())
        <div class="card card-figma p-5 text-center my-4">
            <i class="fa-solid fa-cart-shopping text-caramel fs-1 mb-3"></i>
            <h4 class="font-serif fw-bold text-primary">Keranjang Belanja Kosong</h4>
            <p class="text-muted small mb-4">Anda belum memasukkan roti favorit Anda ke dalam keranjang.</p>
            <a href="{{ route('shop') }}" class="btn btn-caramel px-4 py-3 align-self-center">Belanja Sekarang</a>
        </div>
    @else
        <div class="row g-4">
            <!-- Left Column: Individual Cart Item Cards -->
            <div class="col-lg-8">
                <div class="d-flex flex-column gap-3">
                    @foreach($items as $item)
                        <div class="card card-figma border-0 p-3 shadow-sm position-relative">
                            <div class="d-flex gap-3 align-items-center">
                                <!-- Image -->
                                <div class="rounded overflow-hidden flex-shrink-0" style="width: 100px; height: 100px;">
                                     @php
                                         if (str_starts_with($item->product->image ?? '', 'http')) {
                                             $itemImg = $item->product->image;
                                         } elseif ($item->product->image) {
                                             $itemImg = str_starts_with($item->product->image, 'images/') ? asset($item->product->image) : asset('storage/' . $item->product->image);
                                         } else {
                                             $itemImg = 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=400';
                                         }
                                     @endphp
                                     <img src="{{ $itemImg }}" class="w-100 h-100" alt="{{ $item->product->name }}" style="object-fit: cover;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800';">
                                </div>

                                <!-- Middle Details -->
                                <div class="flex-grow-1">
                                    <span class="badge text-dark mb-1" style="background-color: #F3EBDD; color: #593E22; font-size: 0.65rem;">
                                        {{ $item->product->category->name ?? 'Kategori' }}
                                    </span>
                                    <h6 class="fw-bold text-primary mb-1">{{ $item->product->name }}</h6>
                                    <p class="text-muted small mb-2 text-truncate-2" style="font-size: 0.78rem;">
                                        {{ $item->notes ?: ($item->product->description ?: 'Roti segar dipanggang setiap hari.') }}
                                    </p>

                                    <!-- Quantity selector -->
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <div class="input-group input-group-sm" style="width: 110px;">
                                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="this.parentNode.querySelector('input').stepDown(); this.form.submit();">-</button>
                                            <input type="number" name="quantity" class="form-control text-center bg-white border-secondary-subtle fw-semibold" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" readonly>
                                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="this.parentNode.querySelector('input').stepUp(); this.form.submit();">+</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Right: Price (Sans-serif bold matching Figma Image 1) & Delete Button -->
                                <div class="text-end d-flex flex-column justify-content-between align-items-end h-100">
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item dari keranjang?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-muted p-0 border-0 mb-3"><i class="fa-regular fa-trash-can"></i></button>
                                    </form>
                                    <span class="fw-bold text-primary fs-5">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Column: Ringkasan Pesanan Card -->
            <div class="col-lg-4">
                <div class="card card-figma border-0 p-4 shadow-sm">
                    <h5 class="font-serif fw-bold text-primary mb-4 border-bottom border-light pb-2">Ringkasan Pesanan</h5>

                    @php
                        $tax = $totalAmount * 0.10;
                        $grandTotal = $totalAmount + $tax;
                    @endphp

                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Subtotal ({{ $totalItems }} item)</span>
                        <span class="fw-bold text-primary">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Pajak (10%)</span>
                        <span class="fw-bold text-primary">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-muted">Biaya Pengiriman</span>
                        <span class="text-muted fst-italic">Dihitung di Checkout</span>
                    </div>

                    <hr class="border-light my-3">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold text-primary">Total</span>
                        <span class="fw-bold text-caramel fs-3">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-caramel w-100 py-3 mb-3">
                        Lanjut ke Checkout <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>

                    <div class="text-center text-muted small my-2" style="font-size: 0.75rem;">ATAU</div>

                    <a href="{{ route('shop') }}" class="btn btn-caramel-outline w-100 py-2 text-center text-decoration-none small mb-4">
                        Tambah Produk Lain
                    </a>

                    <div class="p-2 rounded bg-bakery-cream small text-muted d-flex align-items-center gap-2" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-circle-check text-success fs-6"></i>
                        <span>Pembayaran aman. Roti dipanggang segar setiap pagi sebelum pengiriman.</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
