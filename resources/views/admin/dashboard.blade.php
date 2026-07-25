@extends('layouts.admin')

@section('title', 'Ringkasan Hari Ini')

@section('content')
<div class="container-fluid p-0">
    <!-- Top 4 Metric Cards Grid (Compact & Elegant Layout) -->
    <div class="row g-3 mb-4">
        <!-- Card 1: TOTAL PENJUALAN -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-figma border-0 p-3 shadow-sm h-100">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="text-uppercase fw-bold text-muted" style="font-size: 0.65rem; letter-spacing: 0.5px;">TOTAL PENJUALAN</span>
                    <div class="rounded-3 p-1.5 text-caramel d-flex align-items-center justify-content-center flex-shrink-0" style="background-color: #FAF3E8; width: 34px; height: 34px;">
                        <i class="fa-solid fa-money-bill-wave" style="font-size: 0.9rem;"></i>
                    </div>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0 text-nowrap" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.3rem; line-height: 1.25;">
                        Rp {{ number_format($totalSales ?? 4250000, 0, ',', '.') }}
                    </h4>
                </div>
                <div class="mt-1.5">
                    <span class="text-success fw-semibold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-arrow-trend-up me-1"></i> +12.5% dari kemarin
                    </span>
                </div>
            </div>
        </div>

        <!-- Card 2: PESANAN BARU -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-figma border-0 p-3 shadow-sm h-100">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="text-uppercase fw-bold text-muted" style="font-size: 0.65rem; letter-spacing: 0.5px;">PESANAN BARU</span>
                    <div class="rounded-3 p-1.5 text-caramel d-flex align-items-center justify-content-center flex-shrink-0" style="background-color: #FAF3E8; width: 34px; height: 34px;">
                        <i class="fa-solid fa-bag-shopping" style="font-size: 0.9rem;"></i>
                    </div>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.35rem; line-height: 1.25;">
                        {{ $newOrdersCount ?? 24 }}
                    </h4>
                </div>
                <div class="mt-1.5">
                    <span class="text-muted" style="font-size: 0.72rem;">
                        <strong class="text-primary">{{ $unverifiedCount ?? 3 }}</strong> perlu diproses
                    </span>
                </div>
            </div>
        </div>

        <!-- Card 3: STOK MENIPIS -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-figma border-0 p-3 shadow-sm h-100">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="text-uppercase fw-bold text-muted" style="font-size: 0.65rem; letter-spacing: 0.5px;">STOK MENIPIS</span>
                    <div class="rounded-3 p-1.5 text-danger bg-danger-subtle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 34px; height: 34px;">
                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 0.9rem;"></i>
                    </div>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0 text-nowrap" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.35rem; line-height: 1.25;">
                        {{ $lowStockCount ?? 5 }} <span class="fs-6 text-muted fw-normal" style="font-size: 0.85rem !important;">Item</span>
                    </h4>
                </div>
                <div class="mt-1.5">
                    <span class="text-muted text-truncate d-block" style="font-size: 0.72rem;">
                        Sourdough, Croissant...
                    </span>
                </div>
            </div>
        </div>

        <!-- Card 4: PELANGGAN BARU -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-figma border-0 p-3 shadow-sm h-100">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="text-uppercase fw-bold text-muted" style="font-size: 0.65rem; letter-spacing: 0.5px;">PELANGGAN BARU</span>
                    <div class="rounded-3 p-1.5 text-caramel d-flex align-items-center justify-content-center flex-shrink-0" style="background-color: #FAF3E8; width: 34px; height: 34px;">
                        <i class="fa-solid fa-user-plus" style="font-size: 0.9rem;"></i>
                    </div>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.35rem; line-height: 1.25;">
                        {{ $newCustomersCount ?? 18 }}
                    </h4>
                </div>
                <div class="mt-1.5">
                    <span class="text-success fw-semibold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-arrow-trend-up me-1"></i> +4.2% minggu ini
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Orders Row (Figma Screenshot 2) -->
    <div class="row g-4">
        <!-- Left: Tren Penjualan Bar Chart -->
        <div class="col-lg-8">
            <div class="card card-figma border-0 p-4 shadow-sm h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="font-serif fw-bold text-primary mb-0">Tren Penjualan (Minggu Ini)</h5>
                    <a href="{{ route('admin.reports.index') }}" class="text-caramel small fw-bold text-decoration-none">Lihat Detail &gt;</a>
                </div>
                <div style="height: 280px;">
                    <canvas id="salesTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Right: Pesanan Perlu Diproses List -->
        <div class="col-lg-4">
            <div class="card card-figma border-0 p-4 shadow-sm h-100 d-flex flex-column">
                <h5 class="font-serif fw-bold text-primary mb-3">Pesanan Perlu Diproses</h5>

                <div class="table-responsive mb-3">
                    <table class="table align-middle table-borderless small mb-0">
                        <thead>
                            <tr class="text-muted border-bottom" style="font-size: 0.72rem;">
                                <th class="ps-0">ID</th>
                                <th>PELANGGAN</th>
                                <th class="text-end pe-0">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                                <tr>
                                    <td class="ps-0 fw-bold text-primary small">#{{ Str::limit($order->order_code, 9, '') }}</td>
                                    <td>{{ $order->user->name ?? 'Pelanggan' }}</td>
                                    <td class="text-end pe-0">
                                        @if($order->payment_status === 'waiting_verification')
                                            <span class="badge py-1.5 px-2.5 rounded-pill" style="background-color: #FAF3E8; color: #593E22;">Menunggu</span>
                                        @elseif($order->status === 'processing')
                                            <span class="badge py-1.5 px-2.5 rounded-pill" style="background-color: #E2F0D9; color: #385723;">Dikemas</span>
                                        @else
                                            <span class="badge py-1.5 px-2.5 rounded-pill bg-light text-dark">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="ps-0 fw-bold text-primary small">#ORD-092</td>
                                    <td>Ibu Siti</td>
                                    <td class="text-end pe-0"><span class="badge py-1.5 px-2.5 rounded-pill" style="background-color: #FAF3E8; color: #593E22;">Menunggu</span></td>
                                </tr>
                                <tr>
                                    <td class="ps-0 fw-bold text-primary small">#ORD-093</td>
                                    <td>Bpk. Agus</td>
                                    <td class="text-end pe-0"><span class="badge py-1.5 px-2.5 rounded-pill" style="background-color: #FAF3E8; color: #593E22;">Menunggu</span></td>
                                </tr>
                                <tr>
                                    <td class="ps-0 fw-bold text-primary small">#ORD-094</td>
                                    <td>Maya</td>
                                    <td class="text-end pe-0"><span class="badge py-1.5 px-2.5 rounded-pill" style="background-color: #E2F0D9; color: #385723;">Dikemas</span></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('admin.orders.index') }}" class="btn btn-caramel-outline w-100 py-2.5 text-center text-decoration-none mt-auto">
                    Lihat Semua Pesanan
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesTrendChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Ming'],
            datasets: [{
                label: 'Penjualan (Rp)',
                data: [2200000, 3800000, 5100000, 2900000, 4250000, 6000000, 4800000],
                backgroundColor: [
                    '#F3EBDD',
                    '#F3EBDD',
                    '#C89D7C',
                    '#F3EBDD',
                    '#F3EBDD',
                    '#F3EBDD',
                    '#F3EBDD'
                ],
                borderRadius: 8,
                borderSkipped: false,
                barThickness: 32
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(val) {
                            if(val >= 1000000) return (val/1000000) + 'M';
                            return val;
                        }
                    },
                    grid: { color: '#F0E6D8' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endsection
