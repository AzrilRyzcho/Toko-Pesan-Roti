@extends('layouts.admin')

@section('title', '')

@section('content')
<style>
    @media print {
        /* Hide sidebar, topbar, filter buttons, and any SweetAlert popups completely */
        aside.admin-sidebar,
        header.admin-topbar,
        .no-print,
        .swal2-container,
        .swal2-backdrop-show,
        .swal2-popup,
        button {
            display: none !important;
            visibility: hidden !important;
        }

        /* Make main container fill 100% print width cleanly */
        html, body {
            background-color: #FFFFFF !important;
            background: #FFFFFF !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }
        
        .admin-main {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 15px !important;
            background-color: #FFFFFF !important;
        }

        .container-fluid {
            padding: 0 !important;
        }

        /* Clean card styles for PDF print */
        .card-figma {
            box-shadow: none !important;
            border: 1px solid #EADBCE !important;
            page-break-inside: avoid;
        }

        /* Clean table for print */
        .table {
            width: 100% !important;
        }
    }
</style>

<div class="container-fluid p-0">
    <!-- Top Header Row (Figma Screenshot 5) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <span class="text-muted small d-block mb-1" style="font-size: 0.75rem;">Admin &gt; Laporan Penjualan</span>
            <h3 class="font-serif fw-bold text-primary mb-1">Laporan Penjualan</h3>
            <p class="text-muted small mb-0">Ringkasan performa penjualan dan produk terlaris.</p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap no-print">
            <!-- Interactive Filter Tabs (Harian, Mingguan, Bulanan) -->
            <div class="d-flex gap-1 p-1 bg-white rounded-3 border border-secondary-subtle">
                <button type="button" id="btn-harian" onclick="setReportFilter('harian')" class="btn btn-sm px-3 py-1.5 text-muted border-0">Harian</button>
                <button type="button" id="btn-mingguan" onclick="setReportFilter('mingguan')" class="btn btn-sm px-3 py-1.5 fw-bold rounded-2 text-primary" style="background-color: #FAF3E8;">Mingguan</button>
                <button type="button" id="btn-bulanan" onclick="setReportFilter('bulanan')" class="btn btn-sm px-3 py-1.5 text-muted border-0">Bulanan</button>
            </div>

            <!-- Print Button -->
            <button type="button" class="btn btn-white bg-white border-secondary-subtle btn-sm px-3 py-2 text-primary" onclick="window.print()">
                <i class="fa-solid fa-print me-1"></i> Cetak
            </button>

            <!-- Export PDF Button -->
            <button type="button" class="btn btn-caramel btn-sm px-3 py-2 text-white" onclick="exportPDF()">
                <i class="fa-solid fa-file-pdf me-1"></i> Ekspor PDF
            </button>
        </div>
    </div>

    <!-- Top 3 Metrics Cards (Compact Layout) -->
    <div class="row g-3 mb-4">
        <!-- Card 1: TOTAL PENDAPATAN -->
        <div class="col-4">
            <div class="card card-figma border-0 p-3 shadow-sm h-100">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="text-uppercase fw-bold text-muted" style="font-size: 0.65rem; letter-spacing: 0.5px;">TOTAL PENDAPATAN</span>
                    <div class="rounded-3 p-1.5 text-caramel d-flex align-items-center justify-content-center flex-shrink-0" style="background-color: #FAF3E8; width: 34px; height: 34px;">
                        <i class="fa-solid fa-money-bill-wave" style="font-size: 0.9rem;"></i>
                    </div>
                </div>
                <div>
                    <h4 id="metric-pendapatan" class="fw-bold text-primary mb-0 text-nowrap" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.3rem; line-height: 1.25;">
                        Rp {{ number_format($totalSales ?: 12450000, 0, ',', '.') }}
                    </h4>
                </div>
                <div class="mt-1.5">
                    <span id="metric-pendapatan-sub" class="text-success fw-semibold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-arrow-trend-up me-1"></i> +15.2% dibanding minggu lalu
                    </span>
                </div>
            </div>
        </div>

        <!-- Card 2: PESANAN BERHASIL -->
        <div class="col-4">
            <div class="card card-figma border-0 p-3 shadow-sm h-100">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="text-uppercase fw-bold text-muted" style="font-size: 0.65rem; letter-spacing: 0.5px;">PESANAN BERHASIL</span>
                    <div class="rounded-3 p-1.5 text-caramel d-flex align-items-center justify-content-center flex-shrink-0" style="background-color: #FAF3E8; width: 34px; height: 34px;">
                        <i class="fa-solid fa-cart-shopping" style="font-size: 0.9rem;"></i>
                    </div>
                </div>
                <div>
                    <h4 id="metric-pesanan" class="fw-bold text-primary mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.35rem; line-height: 1.25;">
                        184
                    </h4>
                </div>
                <div class="mt-1.5">
                    <span id="metric-pesanan-sub" class="text-success fw-semibold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-arrow-trend-up me-1"></i> +8.5% dibanding minggu lalu
                    </span>
                </div>
            </div>
        </div>

        <!-- Card 3: RATA-RATA TRANSAKSI -->
        <div class="col-4">
            <div class="card card-figma border-0 p-3 shadow-sm h-100">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="text-uppercase fw-bold text-muted" style="font-size: 0.65rem; letter-spacing: 0.5px;">RATA-RATA TRANSAKSI</span>
                    <div class="rounded-3 p-1.5 text-caramel d-flex align-items-center justify-content-center flex-shrink-0" style="background-color: #FAF3E8; width: 34px; height: 34px;">
                        <i class="fa-solid fa-receipt" style="font-size: 0.9rem;"></i>
                    </div>
                </div>
                <div>
                    <h4 id="metric-rata" class="fw-bold text-primary mb-0 text-nowrap" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.3rem; line-height: 1.25;">
                        Rp 67.663
                    </h4>
                </div>
                <div class="mt-1.5">
                    <span id="metric-rata-sub" class="text-danger fw-semibold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-arrow-trend-down me-1"></i> -2.1% dibanding minggu lalu
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Chart: Tren Pendapatan (Figma Screenshot 5) -->
    <div class="card card-figma border-0 p-4 mb-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="font-serif fw-bold text-primary mb-0">Tren Pendapatan</h5>
            <button class="btn btn-link text-muted p-0 border-0 no-print"><i class="fa-solid fa-ellipsis-vertical"></i></button>
        </div>
        <div style="height: 260px;">
            <canvas id="revenueLineChart"></canvas>
        </div>
    </div>

    <!-- Bottom Table: Produk Terlaris (Figma Screenshot 5) -->
    <div class="card card-figma border-0 shadow-sm p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="font-serif fw-bold text-primary mb-0">Produk Terlaris</h5>
            <a href="{{ route('admin.products.index') }}" class="text-caramel small fw-bold text-decoration-none no-print">Lihat Semua</a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="bg-bakery-cream text-uppercase text-muted" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                    <tr>
                        <th class="ps-3 py-2.5">PRODUK</th>
                        <th class="py-2.5">KATEGORI</th>
                        <th class="py-2.5">TERJUAL</th>
                        <th class="text-end pe-3 py-2.5">PENDAPATAN</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-top-0">
                    <tr>
                        <td class="ps-3 py-2.5">
                            <div class="d-flex align-items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=150" class="rounded" style="width: 42px; height: 42px; object-fit: cover;">
                                <div>
                                    <span class="fw-bold text-primary small d-block mb-0">Sourdough Classic</span>
                                    <span class="text-muted" style="font-size: 0.68rem;">Roti Artisan</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-2.5 text-muted small">Roti Tawar</td>
                        <td class="py-2.5 fw-bold text-primary small">45 Pcs</td>
                        <td class="text-end pe-3 py-2.5 fw-bold text-caramel">Rp 2.025.000</td>
                    </tr>
                    <tr>
                        <td class="ps-3 py-2.5">
                            <div class="d-flex align-items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=150" class="rounded" style="width: 42px; height: 42px; object-fit: cover;">
                                <div>
                                    <span class="fw-bold text-primary small d-block mb-0">Butter Croissant</span>
                                    <span class="text-muted" style="font-size: 0.68rem;">Pastry</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-2.5 text-muted small">Viennoiserie</td>
                        <td class="py-2.5 fw-bold text-primary small">38 Pcs</td>
                        <td class="text-end pe-3 py-2.5 fw-bold text-caramel">Rp 950.000</td>
                    </tr>
                    <tr>
                        <td class="ps-3 py-2.5">
                            <div class="d-flex align-items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=150" class="rounded" style="width: 42px; height: 42px; object-fit: cover;">
                                <div>
                                    <span class="fw-bold text-primary small d-block mb-0">Chocolate Babka</span>
                                    <span class="text-muted" style="font-size: 0.68rem;">Roti Manis</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-2.5 text-muted small">Roti Manis</td>
                        <td class="py-2.5 fw-bold text-primary small">24 Pcs</td>
                        <td class="text-end pe-3 py-2.5 fw-bold text-caramel">Rp 1.560.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
let reportChart = null;

const reportDatasets = {
    harian: {
        pendapatan: "Rp 1.850.000",
        pendapatanSub: '<i class="fa-solid fa-arrow-trend-up me-1"></i> +5.4% dibanding kemarin',
        pesanan: "26",
        pesananSub: '<i class="fa-solid fa-arrow-trend-up me-1"></i> +3 dibanding kemarin',
        rata: "Rp 71.153",
        rataSub: '<i class="fa-solid fa-arrow-trend-up me-1"></i> +2.1% dibanding kemarin',
        labels: ['06:00', '09:00', '12:00', '15:00', '18:00', '21:00'],
        data: [250000, 480000, 520000, 310000, 190000, 100000]
    },
    mingguan: {
        pendapatan: "Rp 12.450.000",
        pendapatanSub: '<i class="fa-solid fa-arrow-trend-up me-1"></i> +15.2% dibanding minggu lalu',
        pesanan: "184",
        pesananSub: '<i class="fa-solid fa-arrow-trend-up me-1"></i> +8.5% dibanding minggu lalu',
        rata: "Rp 67.663",
        rataSub: '<i class="fa-solid fa-arrow-trend-down me-1"></i> -2.1% dibanding minggu lalu',
        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
        data: [1200000, 1850000, 1900000, 2400000, 2300000, 2800000, 2000000]
    },
    bulanan: {
        pendapatan: "Rp 54.200.000",
        pendapatanSub: '<i class="fa-solid fa-arrow-trend-up me-1"></i> +22.8% dibanding bulan lalu',
        pesanan: "792",
        pesananSub: '<i class="fa-solid fa-arrow-trend-up me-1"></i> +18.4% dibanding bulan lalu',
        rata: "Rp 68.434",
        rataSub: '<i class="fa-solid fa-arrow-trend-up me-1"></i> +3.7% dibanding bulan lalu',
        labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
        data: [12500000, 14800000, 13900000, 13000000]
    }
};

function setReportFilter(period) {
    document.querySelectorAll('#btn-harian, #btn-mingguan, #btn-bulanan').forEach(btn => {
        btn.className = 'btn btn-sm px-3 py-1.5 text-muted border-0';
        btn.style.backgroundColor = 'transparent';
        btn.style.fontWeight = 'normal';
    });

    const activeBtn = document.getElementById('btn-' + period);
    if (activeBtn) {
        activeBtn.className = 'btn btn-sm px-3 py-1.5 fw-bold rounded-2 text-primary';
        activeBtn.style.backgroundColor = '#FAF3E8';
    }

    const data = reportDatasets[period];
    if (data) {
        document.getElementById('metric-pendapatan').innerText = data.pendapatan;
        document.getElementById('metric-pendapatan-sub').innerHTML = data.pendapatanSub;
        document.getElementById('metric-pesanan').innerText = data.pesanan;
        document.getElementById('metric-pesanan-sub').innerHTML = data.pesananSub;
        document.getElementById('metric-rata').innerText = data.rata;
        document.getElementById('metric-rata-sub').innerHTML = data.rataSub;

        if (reportChart) {
            reportChart.data.labels = data.labels;
            reportChart.data.datasets[0].data = data.data;
            reportChart.update();
        }
    }
}

function exportPDF() {
    window.print();
}

document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('revenueLineChart').getContext('2d');
    
    const gradient = ctx.createLinearGradient(0, 0, 0, 240);
    gradient.addColorStop(0, 'rgba(200, 157, 124, 0.45)');
    gradient.addColorStop(1, 'rgba(200, 157, 124, 0.02)');

    reportChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: reportDatasets.mingguan.labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: reportDatasets.mingguan.data,
                borderColor: '#C89D7C',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                backgroundColor: gradient,
                pointBackgroundColor: '#4A3319',
                pointRadius: 4
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
                    ticks: { display: false },
                    grid: { display: false }
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
