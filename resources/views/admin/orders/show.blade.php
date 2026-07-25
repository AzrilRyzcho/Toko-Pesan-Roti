@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="text-muted small">Detail Pesanan</span>
            <h2 class="font-serif fw-bold text-primary font-monospace mb-0">{{ $order->order_code }}</h2>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm px-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Pesanan
        </a>
    </div>

    <div class="row g-4">
        <!-- Customer & Items Information -->
        <div class="col-lg-7">
            <!-- Customer Details Card -->
            <div class="card card-figma border-0 p-4 mb-4 shadow-sm">
                <h5 class="font-serif fw-bold text-primary mb-3 border-bottom border-light pb-2">Informasi Pemesan & Pengiriman</h5>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <span class="text-muted small d-block">Nama Pelanggan</span>
                        <span class="fw-bold text-primary">{{ $order->user->name }}</span>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted small d-block">Email & WhatsApp</span>
                        <span class="fw-semibold text-primary">{{ $order->user->email }}</span><br>
                        <span class="small text-muted">{{ $order->user->phone ?: 'Tidak ada no telp' }}</span>
                    </div>
                    <div class="col-12">
                        <span class="text-muted small d-block">Alamat Pengiriman Lengkap</span>
                        <p class="mb-0 bg-light p-3 rounded text-primary small mt-1 border-start border-gold">{{ $order->shipping_address }}</p>
                    </div>
                    @if($order->notes)
                        <div class="col-12">
                            <span class="text-muted small d-block">Catatan Tambahan Pelanggan</span>
                            <p class="mb-0 text-muted small fst-italic">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ordered Items List -->
            <div class="card card-figma border-0 p-4 shadow-sm">
                <h5 class="font-serif fw-bold text-primary mb-3 border-bottom border-light pb-2">Daftar Roti & Pastry Dipesan</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr class="text-muted small">
                                <th scope="col" colspan="2" class="border-0">Produk</th>
                                <th scope="col" class="border-0">Harga Unit</th>
                                <th scope="col" class="border-0 text-center">Jumlah</th>
                                <th scope="col" class="border-0 text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td style="width: 60px;" class="border-light">
                                         @if($item->product->image)
                                             @php
                                                 $ordImg = str_starts_with($item->product->image ?? '', 'http') ? $item->product->image : (str_starts_with($item->product->image, 'images/') ? asset($item->product->image) : asset('storage/' . $item->product->image));
                                             @endphp
                                             <img src="{{ $ordImg }}" class="rounded" alt="{{ $item->product->name }}" style="width: 50px; height: 50px; object-fit: cover;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800';">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fa-solid fa-image text-muted fs-6"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="border-light">
                                        <h6 class="font-serif fw-bold text-primary mb-0 small">{{ $item->product->name }}</h6>
                                        @if($item->notes)
                                            <span class="d-block text-gold" style="font-size: 0.7rem;">Note: "{{ $item->notes }}"</span>
                                        @endif
                                    </td>
                                    <td class="border-light small text-primary">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="border-light text-center small font-monospace">
                                        x{{ $item->quantity }}
                                    </td>
                                    <td class="border-light text-end fw-bold text-primary small">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-light">
                    <span class="font-serif fw-bold text-primary fs-5">Total Tagihan</span>
                    <span class="font-serif fw-bold text-primary fs-4">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Order Management & Payment Proof Column -->
        <div class="col-lg-5">
            <!-- Order Status Management Card -->
            <div class="card card-figma border-0 p-4 mb-4 shadow-sm">
                <h5 class="font-serif fw-bold text-primary mb-3 border-bottom border-light pb-2">Status Pesanan</h5>
                
                <div class="mb-3">
                    <span class="text-muted small d-block mb-1">Status Saat Ini</span>
                    <span class="badge fs-6 {{ $order->status_badge_class }} py-2 px-3">
                        {{ Str::upper($order->status) }}
                    </span>
                </div>

                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="mt-3">
                    @csrf
                    <label for="status" class="form-label fw-semibold text-primary small">Ubah Status Pesanan</label>
                    <div class="input-group">
                        <select name="status" id="status" class="form-select form-select-sm">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>PENDING (Menunggu)</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>PROCESSING (Sedang Dipanggang/Diproses)</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>COMPLETED (Selesai/Dikirim)</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>CANCELLED (Batal - Stok Dikembalikan)</option>
                        </select>
                        <button type="submit" class="btn btn-caramel btn-sm">Update</button>
                    </div>
                </form>
            </div>

            <!-- Payment Proof & Verification Card -->
            <div class="card card-figma border-0 p-4 shadow-sm">
                <h5 class="font-serif fw-bold text-primary mb-3 border-bottom border-light pb-2">Verifikasi Pembayaran</h5>

                <div class="mb-3">
                    <span class="text-muted small d-block mb-1">Status Pembayaran</span>
                    <span class="badge fs-6 {{ $order->payment_status_badge_class }} py-2 px-3">
                        {{ Str::title(str_replace('_', ' ', $order->payment_status)) }}
                    </span>
                </div>

                @if($order->payment_proof)
                    <div class="mb-4 text-center">
                        <span class="text-muted small d-block mb-2">Bukti Transfer Pelanggan</span>
                        @php
                            $proofUrl = str_starts_with($order->payment_proof, 'http') ? $order->payment_proof : asset('storage/' . $order->payment_proof);
                        @endphp
                        <a href="{{ $proofUrl }}" target="_blank">
                            <img src="{{ $proofUrl }}" class="img-fluid rounded shadow-sm border border-light" alt="Bukti Transfer" style="max-height: 250px; object-fit: contain;">
                        </a>
                        <span class="text-muted d-block mt-1" style="font-size: 0.72rem;">Klik gambar untuk memperbesar</span>
                    </div>

                    @if($order->payment_status === 'waiting_verification')
                        <div class="d-flex gap-2 border-top border-light pt-3">
                            <form action="{{ route('admin.orders.verify-payment', $order->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" class="btn btn-success w-100 py-2">
                                    <i class="fa-solid fa-check me-1"></i> Disetujui (Approve)
                                </button>
                            </form>

                            <button type="button" class="btn btn-outline-danger py-2" data-bs-toggle="collapse" data-bs-target="#rejectCollapse">
                                Tolak
                            </button>
                        </div>

                        <div class="collapse mt-3" id="rejectCollapse">
                            <form action="{{ route('admin.orders.verify-payment', $order->id) }}" method="POST" class="card p-3 border-danger bg-light">
                                @csrf
                                <input type="hidden" name="action" value="reject">
                                <label for="reject_reason" class="form-label text-danger fw-semibold small">Alasan Penolakan</label>
                                <textarea name="reject_reason" id="reject_reason" class="form-control form-control-sm mb-2" rows="2" placeholder="Contoh: Bukti transfer buram / nominal tidak sesuai" required></textarea>
                                <button type="submit" class="btn btn-danger btn-sm w-100">Kirim Penolakan</button>
                            </form>
                        </div>
                    @endif
                @else
                    <div class="alert alert-secondary text-center py-4 my-2" role="alert">
                        <i class="fa-solid fa-file-image text-muted fs-2 mb-2"></i>
                        <p class="text-muted small mb-0">Pelanggan belum mengunggah bukti transfer pembayaran.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
