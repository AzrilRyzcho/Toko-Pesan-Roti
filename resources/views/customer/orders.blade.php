@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <!-- Left Sidebar Card (Figma Layout) -->
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
                    <a href="{{ route('orders.index') }}" class="profile-nav-link active">
                        <i class="fa-solid fa-clock-rotate-left me-2"></i> Riwayat Pesanan
                    </a>
                    <a href="{{ route('favorites.index') }}" class="profile-nav-link">
                        <i class="fa-regular fa-heart me-2"></i> Favorit
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
                        <h4 class="font-serif fw-bold text-primary mb-1">Riwayat Pesanan</h4>
                        <p class="text-muted small mb-0">Pantau dan cek status pesanan roti yang telah Anda buat.</p>
                    </div>
                    <span class="badge bg-bakery-cream text-primary border border-secondary-subtle px-3 py-2 fw-semibold">
                        {{ $orders->total() }} Pesanan
                    </span>
                </div>

                @if($orders->isEmpty())
                    <div class="text-center py-5">
                        <i class="fa-solid fa-clipboard-list text-muted mb-3" style="font-size: 3rem; opacity: 0.4;"></i>
                        <h5 class="font-serif fw-bold text-primary mb-1">Belum Ada Pesanan</h5>
                        <p class="text-muted small mb-4">Anda belum melakukan pemesanan roti apapun saat ini.</p>
                        <a href="{{ route('shop') }}" class="btn btn-caramel px-4 py-2">
                            <i class="fa-solid fa-store me-1"></i> Mulai Belanja
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle table-hover">
                            <thead class="bg-bakery-cream text-uppercase text-muted" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                                <tr>
                                    <th class="py-3">KODE PESANAN</th>
                                    <th class="py-3">TANGGAL</th>
                                    <th class="py-3">TOTAL BELANJA</th>
                                    <th class="py-3">STATUS PESANAN</th>
                                    <th class="py-3">STATUS PEMBAYARAN</th>
                                    <th class="text-end pe-3 py-3">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y border-top-0">
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="py-3">
                                            <span class="font-monospace fw-bold text-primary">#{{ $order->order_code }}</span>
                                        </td>
                                        <td class="py-3 text-muted small">
                                            {{ $order->created_at->format('d M Y, H:i') }} WIB
                                        </td>
                                        <td class="py-3 fw-bold text-caramel">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3">
                                            <span class="badge {{ $order->status_badge_class }}">
                                                {{ Str::upper($order->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <span class="badge {{ $order->payment_status_badge_class }}">
                                                {{ Str::title(str_replace('_', ' ', $order->payment_status)) }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-3 py-3">
                                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-caramel-outline btn-sm py-1.5 px-3">
                                                <i class="fa-solid fa-eye me-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
