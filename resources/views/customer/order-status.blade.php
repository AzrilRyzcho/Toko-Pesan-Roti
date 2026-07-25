@extends('layouts.app')

@section('hide_navbar', true)

@section('content')
<div class="min-vh-100 d-flex flex-column align-items-center justify-content-center py-5 bg-bakery-cream">
    <!-- Header Icon & Title (Figma Screenshot 1) -->
    <div class="text-center mb-4 pt-2">
        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 56px; height: 56px;">
            <i class="fa-solid fa-truck text-caramel fs-3"></i>
        </div>
        <h2 class="font-serif fw-bold text-primary mb-1">Status Pesanan Anda</h2>
        <span class="text-muted small font-monospace">Order #{{ $order->order_code }}</span>
    </div>

    <div class="w-100" style="max-width: 780px;">
        <!-- Card 1: Estimasi Tiba & Stepper -->
        <div class="card card-figma border-0 p-4 p-md-5 mb-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <span class="text-muted small d-block mb-1" style="font-size: 0.75rem;">Estimasi Tiba</span>
                    <h3 class="font-serif fw-bold text-primary mb-0">Hari ini, 14:30 - 15:00</h3>
                </div>
                <span class="badge text-dark py-2 px-3 fw-semibold" style="background-color: #F3EBDD; color: #593E22; font-size: 0.75rem;">
                    {{ $order->status === 'completed' ? 'Tiba di Tujuan' : ($order->status === 'processing' ? 'Sedang Dipanggang' : 'Sedang Dikirim') }}
                </span>
            </div>

            <!-- Horizontal Stepper (Figma Screenshot 1) -->
            <div class="order-horizontal-stepper my-3">
                <!-- Step 1 -->
                <div class="step-item active">
                    <div class="step-icon">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <div class="step-label">Pesanan Diterima</div>
                    <div class="step-time">{{ $order->created_at->format('H:i') }} WIB</div>
                </div>

                <!-- Step 2 -->
                <div class="step-item active">
                    <div class="step-icon">
                        <i class="fa-solid fa-fire-burner"></i>
                    </div>
                    <div class="step-label">Sedang Dipanggang</div>
                    <div class="step-time">{{ $order->created_at->addMinutes(30)->format('H:i') }} WIB</div>
                </div>

                <!-- Step 3 -->
                <div class="step-item {{ in_array($order->status, ['processing', 'completed']) ? 'active' : '' }}">
                    <div class="step-icon">
                        <i class="fa-solid fa-motorcycle"></i>
                    </div>
                    <div class="step-label">Dalam Perjalanan</div>
                    <div class="step-time">{{ $order->created_at->addHours(2)->format('H:i') }} WIB</div>
                </div>

                <!-- Step 4 -->
                <div class="step-item {{ $order->status === 'completed' ? 'active' : '' }}">
                    <div class="step-icon">
                        <i class="fa-solid fa-house"></i>
                    </div>
                    <div class="step-label">Tiba di Tujuan</div>
                    <div class="step-time">{{ $order->status === 'completed' ? 'Selesai' : 'Menunggu' }}</div>
                </div>
            </div>
        </div>

        <!-- Bottom Row: Address & Driver Info -->
        <div class="row g-4 mb-4">
            <!-- Left Card: Alamat Pengiriman -->
            <div class="col-md-7">
                <div class="card card-figma bg-bakery-cream border-0 p-4 h-100 shadow-sm">
                    <div class="fw-bold text-primary small mb-2 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-location-dot text-caramel"></i> Alamat Pengiriman
                    </div>
                    <h6 class="font-serif fw-bold text-primary mb-1 small">{{ $order->user->name }}</h6>
                    <p class="text-muted small mb-2" style="font-size: 0.78rem; line-height: 1.6;">
                        {{ $order->shipping_address }}
                    </p>
                    <span class="text-muted small" style="font-size: 0.75rem;"><i class="fa-solid fa-phone me-1 text-muted"></i> {{ $order->user->phone ?: '0812 3456 7890' }}</span>
                </div>
            </div>

            <!-- Right Card: Mitra Pengantar -->
            <div class="col-md-5">
                <div class="card card-figma border-0 p-4 h-100 shadow-sm text-center d-flex flex-column align-items-center justify-content-center">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=200" class="rounded-circle mb-2 border border-light" alt="Mitra Pengantar" style="width: 56px; height: 56px; object-fit: cover;">
                    <h6 class="font-serif fw-bold text-primary mb-0 small">Andi Kurniawan</h6>
                    <span class="text-muted mb-3 d-block" style="font-size: 0.72rem;">Mitra Pengantar</span>

                    <a href="tel:081234567890" class="btn btn-caramel-outline btn-sm w-100 py-2">
                        <i class="fa-solid fa-phone me-1"></i> Hubungi
                    </a>
                </div>
            </div>
        </div>

        <!-- Center Action Button -->
        <div class="text-center mt-2">
            <a href="{{ route('home') }}" class="btn btn-caramel px-5 py-3">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
