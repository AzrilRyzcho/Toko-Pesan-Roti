@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Top Header (Figma Image 5) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <a href="{{ route('orders.index') }}" class="text-muted small text-decoration-none d-inline-block mb-2">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Riwayat Pesanan
            </a>
            <h2 class="font-serif fw-bold text-primary mb-1">Detail Pesanan</h2>
            <span class="text-muted small font-monospace">Pesanan #{{ $order->order_code }}</span> &bull; 
            <span class="text-muted small">Dibuat pada {{ $order->created_at->format('d M Y, H:i') }} WIB</span>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-caramel-outline btn-sm py-2 px-3" onclick="window.print()">
                <i class="fa-solid fa-download me-1"></i> Unduh Invoice
            </button>
            <a href="{{ route('shop') }}" class="btn btn-caramel btn-sm py-2 px-3">
                Pesan Ulang
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Status Pengiriman & Daftar Item -->
        <div class="col-lg-7">
            <!-- Card 1: Status Pengiriman -->
            <div class="card card-figma border-0 p-4 mb-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-light pb-2">
                    <h5 class="font-serif fw-bold text-primary mb-0">Status Pengiriman</h5>
                    <span class="badge bg-success rounded-pill px-3 py-2 text-uppercase fw-semibold" style="font-size: 0.7rem;">
                        {{ $order->status === 'completed' ? 'Pesanan Selesai' : Str::upper($order->status) }}
                    </span>
                </div>

                <!-- Vertical Timeline Tracker -->
                <div class="position-relative ps-4 ms-2 border-start border-2 border-success py-1">
                    <!-- Step 1: Diterima / Completed -->
                    <div class="position-relative mb-4">
                        <span class="position-absolute top-0 start-0 translate-middle rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; left: -17px !important;">
                            <i class="fa-solid fa-check fs-7"></i>
                        </span>
                        <h6 class="font-serif fw-bold text-primary mb-0 small">Pesanan Diterima / Selesai</h6>
                        <span class="text-muted" style="font-size: 0.75rem;">{{ $order->updated_at->format('d M Y, H:i') }} WIB</span>
                    </div>

                    <!-- Step 2: Sedang Diantar -->
                    <div class="position-relative mb-4">
                        <span class="position-absolute top-0 start-0 translate-middle rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; left: -17px !important;">
                            <i class="fa-solid fa-truck fs-7"></i>
                        </span>
                        <h6 class="font-serif fw-bold text-primary mb-0 small">Sedang Diantar oleh Kurir</h6>
                        <span class="text-muted" style="font-size: 0.75rem;">{{ $order->created_at->addHours(2)->format('d M Y, H:i') }} WIB</span>
                    </div>

                    <!-- Step 3: Diproses -->
                    <div class="position-relative">
                        <span class="position-absolute top-0 start-0 translate-middle rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; left: -17px !important;">
                            <i class="fa-solid fa-fire-burner fs-7"></i>
                        </span>
                        <h6 class="font-serif fw-bold text-primary mb-0 small">Pesanan Diproses & Dipanggang</h6>
                        <span class="text-muted" style="font-size: 0.75rem;">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Daftar Item -->
            <div class="card card-figma border-0 p-4 shadow-sm">
                <h5 class="font-serif fw-bold text-primary mb-3 border-bottom border-light pb-2">Daftar Item</h5>

                <div class="d-flex flex-column gap-3">
                    @foreach($order->items as $item)
                        <div class="d-flex align-items-center justify-content-between border-bottom border-light pb-3">
                            <div class="d-flex align-items-center gap-3">
                                 <div class="rounded overflow-hidden flex-shrink-0" style="width: 65px; height: 65px;">
                                     @php
                                         if (str_starts_with($item->product->image ?? '', 'http')) {
                                             $trkImg = $item->product->image;
                                         } elseif ($item->product && $item->product->image) {
                                             $trkImg = str_starts_with($item->product->image, 'images/') ? asset($item->product->image) : asset('storage/' . $item->product->image);
                                         } else {
                                             $trkImg = 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=200';
                                         }
                                     @endphp
                                     <img src="{{ $trkImg }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $item->product->name }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800';">
                                 </div>
                                <div>
                                    <h6 class="font-serif fw-bold text-primary mb-0 small">{{ $item->product->name }}</h6>
                                    @if($item->notes)
                                        <span class="d-block text-muted" style="font-size: 0.72rem;">Catatan: {{ $item->notes }}</span>
                                    @endif
                                    <span class="text-muted" style="font-size: 0.75rem;">{{ $item->quantity }}x</span>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="d-block text-muted small">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                <span class="fw-bold text-primary small">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column: Ringkasan Pembayaran & Informasi Pengiriman -->
        <div class="col-lg-5">
            <!-- Card 1: Ringkasan Pembayaran -->
            <div class="card card-figma border-0 p-4 mb-4 shadow-sm">
                <h5 class="font-serif fw-bold text-primary mb-4 border-bottom border-light pb-2">Ringkasan Pembayaran</h5>

                <div class="d-flex justify-content-between mb-2 small">
                    <span class="text-muted">Total Harga ({{ $order->items->sum('quantity') }} Barang)</span>
                    <span class="fw-semibold text-primary">Rp {{ number_format($order->total_amount - 17000, 0, ',', '.') }}</span>
                </div>

                <div class="d-flex justify-content-between mb-2 small">
                    <span class="text-muted">Ongkos Kirim</span>
                    <span class="fw-semibold text-primary">Rp 15.000</span>
                </div>

                <div class="d-flex justify-content-between mb-3 small">
                    <span class="text-muted">Biaya Layanan</span>
                    <span class="fw-semibold text-primary">Rp 2.000</span>
                </div>

                <hr class="border-light my-2">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="font-serif fw-bold text-primary">Total Pembayaran</span>
                    <span class="font-serif fw-bold text-caramel fs-4">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>

                <div class="p-3 bg-bakery-cream rounded border border-light text-center">
                    <span class="fw-semibold text-primary small"><i class="fa-solid fa-credit-card me-1 text-caramel"></i> Transfer Bank / {{ strtoupper($order->payment_method) }}</span>
                    <span class="d-block text-muted" style="font-size: 0.72rem;">Status: Lunas & Terverifikasi</span>
                </div>
            </div>

            <!-- Card 2: Informasi Pengiriman -->
            <div class="card card-figma border-0 p-4 shadow-sm">
                <h5 class="font-serif fw-bold text-primary mb-3 border-bottom border-light pb-2">Informasi Pengiriman</h5>

                <div class="mb-3">
                    <span class="text-muted d-block" style="font-size: 0.72rem;">Kurir</span>
                    <span class="fw-semibold text-primary small"><i class="fa-solid fa-truck-fast text-caramel me-1"></i> Pengiriman Instan (Toko Pesan Roti)</span>
                </div>

                <div>
                    <span class="text-muted d-block" style="font-size: 0.72rem;">Alamat Tujuan</span>
                    <h6 class="font-serif fw-bold text-primary mb-1 small">{{ $order->user->name }}</h6>
                    <p class="text-muted small mb-0" style="line-height: 1.6; font-size: 0.78rem;">
                        {{ $order->shipping_address }}
                    </p>
                    <span class="text-muted small d-block mt-1">{{ $order->user->phone ?: '081234567890' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
