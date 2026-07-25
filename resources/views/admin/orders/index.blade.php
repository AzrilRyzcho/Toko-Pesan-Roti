@extends('layouts.admin')

@section('title', '')

@section('content')
<div class="container-fluid p-0">
    <!-- Top Header Row (Figma Screenshot 1) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="font-serif fw-bold text-primary mb-1">Kelola Pesanan</h3>
        </div>

        <div class="d-flex align-items-center gap-3">
            @php
                $unverifiedCount = \App\Models\Order::where('payment_status', 'waiting_verification')->count();
            @endphp
            <a href="{{ route('admin.orders.verify') }}" class="btn btn-caramel-outline px-3 py-2 rounded-3 text-decoration-none d-flex align-items-center gap-2">
                <i class="fa-solid fa-square-check text-caramel"></i>
                <span class="fw-bold text-primary small">Verifikasi Pembayaran</span>
                <span class="badge rounded-circle bg-caramel text-white px-2 py-1" style="font-size: 0.72rem;">{{ $unverifiedCount }}</span>
            </a>
        </div>
    </div>

    <!-- Filter Pills & Search Bar (Figma Screenshot 1 Fix) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <!-- Filter Tabs -->
        <div class="d-flex align-items-center gap-2 overflow-x-auto pb-2 pb-md-0" style="white-space: nowrap;">
            @php $currentStatus = request('status'); @endphp
            
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm rounded-pill px-3.5 py-1.5 fw-bold" style="{{ !$currentStatus ? 'background-color: #4A3319; color: #FFFFFF !important;' : 'background-color: #FAF6ED; color: #8C735C; border: 1px solid #EADBCE;' }}">
                Semua Pesanan
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'unpaid']) }}" class="btn btn-sm rounded-pill px-3.5 py-1.5 fw-bold" style="{{ $currentStatus === 'unpaid' ? 'background-color: #4A3319; color: #FFFFFF !important;' : 'background-color: #FAF6ED; color: #8C735C; border: 1px solid #EADBCE;' }}">
                Menunggu Pembayaran
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="btn btn-sm rounded-pill px-3.5 py-1.5 fw-bold" style="{{ $currentStatus === 'processing' ? 'background-color: #4A3319; color: #FFFFFF !important;' : 'background-color: #FAF6ED; color: #8C735C; border: 1px solid #EADBCE;' }}">
                Diproses
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="btn btn-sm rounded-pill px-3.5 py-1.5 fw-bold" style="{{ $currentStatus === 'shipped' ? 'background-color: #4A3319; color: #FFFFFF !important;' : 'background-color: #FAF6ED; color: #8C735C; border: 1px solid #EADBCE;' }}">
                Dikirim
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="btn btn-sm rounded-pill px-3.5 py-1.5 fw-bold" style="{{ $currentStatus === 'completed' ? 'background-color: #4A3319; color: #FFFFFF !important;' : 'background-color: #FAF6ED; color: #8C735C; border: 1px solid #EADBCE;' }}">
                Selesai
            </a>
        </div>

        <!-- Search & Download Button -->
        <div class="d-flex align-items-center gap-2">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex align-items-center gap-2">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="input-group" style="width: 220px;">
                    <span class="input-group-text bg-white border-secondary-subtle text-muted">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-white border-secondary-subtle small" placeholder="Cari ID atau Nama...">
                </div>
            </form>

            <!-- Export CSV Button (Functional) -->
            <a href="{{ route('admin.orders.index', array_merge(request()->all(), ['export' => 'csv'])) }}" class="btn btn-light border text-muted p-2 rounded-3" title="Unduh CSV Data Pesanan">
                <i class="fa-solid fa-download"></i>
            </a>
        </div>
    </div>

    <!-- Orders Table Card (Figma Screenshot 1) -->
    <div class="card card-figma border-0 shadow-sm p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="bg-bakery-cream text-uppercase text-muted" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                    <tr>
                        <th class="ps-4 py-3">ID PESANAN</th>
                        <th class="py-3">NAMA PELANGGAN</th>
                        <th class="py-3">TANGGAL</th>
                        <th class="py-3">TOTAL</th>
                        <th class="py-3">STATUS</th>
                        <th class="text-end pe-4 py-3">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-top-0">
                    @forelse($orders as $order)
                        <tr>
                            <td class="ps-4 py-3 fw-bold text-primary">#{{ $order->order_code }}</td>
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-bakery-cream text-caramel fw-bold d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                        {{ strtoupper(substr($order->user->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <span class="fw-semibold text-primary small">{{ $order->user->name ?? 'Pelanggan' }}</span>
                                </div>
                            </td>
                            <td class="py-3 text-muted small">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="py-3 fw-bold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="py-3">
                                @if($order->payment_status === 'unpaid')
                                    <span class="badge py-1.5 px-3 rounded-pill" style="background-color: #FAF3E8; color: #8C735C;">• Menunggu Pembayaran</span>
                                @elseif($order->payment_status === 'waiting_verification')
                                    <span class="badge py-1.5 px-3 rounded-pill" style="background-color: #FFF2CC; color: #7F6000;">• Verifikasi Pembayaran</span>
                                @elseif($order->status === 'processing')
                                    <span class="badge py-1.5 px-3 rounded-pill" style="background-color: #FCE4D6; color: #C65911;">• Diproses</span>
                                @elseif($order->status === 'shipped')
                                    <span class="badge py-1.5 px-3 rounded-pill" style="background-color: #D9E1F2; color: #203764;">• Dikirim</span>
                                @else
                                    <span class="badge py-1.5 px-3 rounded-pill" style="background-color: #E2F0D9; color: #385723;">• Selesai</span>
                                @endif
                            </td>
                            <td class="text-end pe-4 py-3">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-link text-muted p-1 border-0" title="Detail Pesanan">
                                    <i class="fa-regular fa-eye fs-6"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="fa-solid fa-folder-open fs-2 text-muted mb-2 d-block"></i>
                                Belum ada data pesanan untuk kategori ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3 bg-white d-flex justify-content-between align-items-center border-top border-light">
            <span class="text-muted small" style="font-size: 0.78rem;">
                Menampilkan {{ $orders->firstItem() ?? 0 }}-{{ $orders->lastItem() ?? 0 }} dari {{ $orders->total() }} pesanan
            </span>
            <div>
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
