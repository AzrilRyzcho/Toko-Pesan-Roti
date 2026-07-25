@extends('layouts.admin')

@section('title', '')

@section('content')
<div class="container-fluid p-0">
    <!-- Top Header & Tabs (Figma Screenshot 2) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="font-serif fw-bold text-primary mb-1">Verifikasi Pembayaran</h3>
            <p class="text-muted small mb-0">Periksa dan validasi bukti transfer yang diunggah pelanggan sebelum memproses pesanan ke dapur.</p>
        </div>

        <div class="d-flex gap-1 p-1 bg-white rounded-3 border border-secondary-subtle">
            <button class="btn btn-sm px-3 py-1.5 fw-bold rounded-2 text-primary" style="background-color: #FAF3E8;">
                Menunggu ({{ $pendingOrders->total() }})
            </button>
            <button class="btn btn-sm px-3 py-1.5 text-muted border-0">
                Riwayat
            </button>
        </div>
    </div>

    <!-- Verification Table Card (Figma Screenshot 2) -->
    <div class="card card-figma border-0 shadow-sm p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="bg-bakery-cream text-uppercase text-muted" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                    <tr>
                        <th class="ps-4 py-3">INFO PESANAN</th>
                        <th class="py-3">PELANGGAN</th>
                        <th class="py-3">TOTAL PEMBAYARAN</th>
                        <th class="py-3">BUKTI TRANSFER</th>
                        <th class="text-end pe-4 py-3">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-top-0">
                    @forelse($pendingOrders as $order)
                        <tr>
                            <td class="ps-4 py-3">
                                <span class="fw-bold text-primary d-block">#{{ $order->order_code }}</span>
                                <span class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-clock me-1"></i> {{ $order->updated_at->diffForHumans() }}</span>
                            </td>
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-bakery-cream text-caramel fw-bold d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; font-size: 0.75rem;">
                                        {{ strtoupper(substr($order->user->name ?? 'A', 0, 2)) }}
                                    </div>
                                    <div>
                                        <span class="fw-bold text-primary small d-block mb-0">{{ $order->user->name }}</span>
                                        <span class="text-muted" style="font-size: 0.7rem;">BCA - xxxx4590</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="fw-bold text-primary fs-6">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-3">
                                @php
                                    $proofImg = str_starts_with($order->payment_proof ?? '', 'http') ? $order->payment_proof : ($order->payment_proof ? asset('storage/' . $order->payment_proof) : 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&q=80&w=200');
                                @endphp
                                <a href="{{ $proofImg }}" target="_blank" title="Klik untuk perbesar">
                                    <img src="{{ $proofImg }}" class="rounded border p-1 bg-white" style="width: 48px; height: 60px; object-fit: cover;">
                                </a>
                            </td>
                            <td class="text-end pe-4 py-3">
                                <div class="d-inline-flex gap-2">
                                    <!-- Reject Form -->
                                    <form action="{{ route('admin.orders.verify-payment', $order->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 rounded-2" onclick="return confirm('Tolak bukti pembayaran ini?')">
                                            <i class="fa-solid fa-xmark me-1"></i> Tolak
                                        </button>
                                    </form>

                                    <!-- Approve Form -->
                                    <form action="{{ route('admin.orders.verify-payment', $order->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="btn btn-caramel btn-sm px-3 rounded-2">
                                            <i class="fa-solid fa-check me-1"></i> Terima
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="fa-solid fa-clipboard-check text-caramel fs-1 mb-2 d-block"></i>
                                Semua bukti pembayaran telah diverifikasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3 bg-white border-top border-light">
            {{ $pendingOrders->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
