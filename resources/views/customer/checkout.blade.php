@extends('layouts.app')

@section('hide_navbar', true)

@section('content')
<div class="container py-4">
    <!-- Header with Back Button (Figma Style) -->
    <div class="mb-4 pt-2">
        <a href="{{ route('cart.index') }}" class="text-muted small text-decoration-none d-inline-block mb-2">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Keranjang
        </a>
        <h2 class="font-serif fw-bold text-primary mb-1">Checkout</h2>
        <p class="text-muted small mb-0">Selesaikan pesanan Anda dengan mengisi detail di bawah ini.</p>
    </div>

    <div class="row g-4">
        <!-- Left Column: Opsi Penerimaan & Forms -->
        <div class="col-lg-7">
            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf
                <input type="hidden" name="delivery_type" id="delivery_type" value="delivery">

                <!-- Opsi Penerimaan Card -->
                <div class="card card-figma border-0 p-4 mb-4 shadow-sm">
                    <h5 class="font-serif fw-bold text-primary mb-3">Opsi Penerimaan</h5>

                    <!-- Delivery Tabs (Interactive Pickup / Delivery Toggle) -->
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div id="option-delivery" class="card p-3 border-caramel bg-bakery-cream cursor-pointer text-center" onclick="selectDeliveryOption('delivery')">
                                <i class="fa-solid fa-truck text-caramel mb-1 fs-5"></i>
                                <span class="fw-bold text-primary small d-block">Kirim ke Alamat</span>
                                <span class="text-muted" style="font-size: 0.7rem;">Diantar oleh kurir kami</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div id="option-pickup" class="card p-3 border-light bg-light cursor-pointer text-center opacity-75" onclick="selectDeliveryOption('pickup')">
                                <i class="fa-solid fa-store text-muted mb-1 fs-5"></i>
                                <span class="fw-semibold text-muted small d-block">Ambil di Toko</span>
                                <span class="text-muted" style="font-size: 0.7rem;">Kunjungi gerai terdekat</span>
                            </div>
                        </div>
                    </div>

                    <div id="address-section">
                        <h6 class="font-serif fw-bold text-primary mb-3">Alamat Pengiriman</h6>

                        <!-- First & Last Name -->
                        @php
                            $nameParts = explode(' ', $user->name, 2);
                            $firstName = $nameParts[0] ?? '';
                            $lastName = $nameParts[1] ?? '';
                        @endphp
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-primary small">Nama Depan</label>
                                <input type="text" class="form-control form-control-figma" value="{{ $firstName }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-primary small">Nama Belakang</label>
                                <input type="text" class="form-control form-control-figma" value="{{ $lastName }}">
                            </div>
                        </div>

                        <!-- Full Address -->
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label fw-semibold text-primary small">Alamat Lengkap</label>
                            <textarea id="shipping_address" name="shipping_address" class="form-control form-control-figma" rows="3" placeholder="Jl. Sudirman No. 123, RT 01/RW 02..." style="height: 90px;" required>{{ old('shipping_address', $user->address) }}</textarea>
                        </div>

                        <!-- City & Zip -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-primary small">Kota / Kabupaten</label>
                                <input type="text" class="form-control form-control-figma" value="Jakarta Selatan">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-primary small">Kode Pos</label>
                                <input type="text" class="form-control form-control-figma" value="12345">
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-2">
                            <label class="form-label fw-semibold text-primary small">Nomor Telepon</label>
                            <input type="text" class="form-control form-control-figma" value="{{ $user->phone ?: '081234567890' }}" required>
                        </div>
                    </div>
                </div>

                <!-- Catatan Card -->
                <div class="card card-figma border-0 p-4 shadow-sm mb-4">
                    <h5 class="font-serif fw-bold text-primary mb-3">Catatan (Opsional)</h5>
                    <textarea name="notes" class="form-control form-control-figma" rows="2" placeholder="Contoh: Tolong potong rotinya, atau ucapkan selamat ulang tahun..." style="height: 80px;">{{ old('notes') }}</textarea>
                </div>
            </form>
        </div>

        <!-- Right Column: Ringkasan Pesanan Card -->
        <div class="col-lg-5">
            <div class="card card-figma border-0 p-4 shadow-sm">
                <h5 class="font-serif fw-bold text-primary mb-4 border-bottom border-light pb-2">Ringkasan Pesanan</h5>

                <!-- Mini item list -->
                <div class="d-flex flex-column gap-3 mb-4">
                    @foreach($items as $item)
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded overflow-hidden flex-shrink-0" style="width: 50px; height: 50px;">
                                     @php
                                         if (str_starts_with($item->product->image ?? '', 'http')) {
                                             $itemImg = $item->product->image;
                                         } elseif ($item->product && $item->product->image) {
                                             $itemImg = str_starts_with($item->product->image, 'images/') ? asset($item->product->image) : asset('storage/' . $item->product->image);
                                         } else {
                                             $itemImg = 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=200';
                                         }
                                     @endphp
                                     <img src="{{ $itemImg }}" class="w-100 h-100" alt="{{ $item->product->name ?? 'Produk' }}" style="object-fit: cover;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800';">
                                </div>
                                <div>
                                    <h6 class="fw-bold text-primary mb-0 small">{{ $item->product->name ?? 'Produk' }}</h6>
                                    <span class="text-muted" style="font-size: 0.72rem;">{{ $item->quantity }} x Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <span class="fw-bold text-primary small">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                @php
                    $shippingFee = 15000;
                    $grandTotal = $totalAmount + $shippingFee;
                @endphp

                <div class="d-flex justify-content-between mb-2 small">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-bold text-primary">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                </div>

                <div class="d-flex justify-content-between mb-3 small">
                    <span class="text-muted">Biaya Pengiriman</span>
                    <span id="shipping-fee-text" class="fw-bold text-primary">Rp {{ number_format($shippingFee, 0, ',', '.') }}</span>
                </div>

                <hr class="border-light my-3">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fw-bold text-primary">Total</span>
                    <span id="grand-total-text" class="fw-bold text-caramel fs-3">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>

                <button type="submit" form="checkout-form" class="btn btn-caramel w-100 py-3 mb-3">
                    Lanjut ke Pembayaran <i class="fa-solid fa-arrow-right ms-1"></i>
                </button>

                <div class="text-center text-muted small" style="font-size: 0.75rem;">
                    <i class="fa-solid fa-lock me-1"></i> Transaksi Anda aman dan terenkripsi
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function selectDeliveryOption(type) {
    const deliveryCard = document.getElementById('option-delivery');
    const pickupCard = document.getElementById('option-pickup');
    const deliveryTypeInput = document.getElementById('delivery_type');
    const shippingFeeText = document.getElementById('shipping-fee-text');
    const grandTotalText = document.getElementById('grand-total-text');
    const addressSection = document.getElementById('address-section');
    const shippingAddressTextarea = document.getElementById('shipping_address');

    const subtotal = {{ $totalAmount }};

    if (type === 'pickup') {
        pickupCard.className = 'card p-3 border-caramel bg-bakery-cream cursor-pointer text-center';
        pickupCard.querySelector('i').className = 'fa-solid fa-store text-caramel mb-1 fs-5';
        pickupCard.querySelector('span.small').className = 'fw-bold text-primary small d-block';

        deliveryCard.className = 'card p-3 border-light bg-light cursor-pointer text-center opacity-75';
        deliveryCard.querySelector('i').className = 'fa-solid fa-truck text-muted mb-1 fs-5';
        deliveryCard.querySelector('span.small').className = 'fw-semibold text-muted small d-block';

        deliveryTypeInput.value = 'pickup';
        shippingFeeText.innerText = 'Gratis (Ambil di Toko)';
        grandTotalText.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');

        addressSection.style.display = 'none';
        shippingAddressTextarea.removeAttribute('required');
        shippingAddressTextarea.value = 'Ambil Langsung di Outlet Toko Pesan Roti (Jl. Bakery Indah No. 1, Jakarta)';
    } else {
        deliveryCard.className = 'card p-3 border-caramel bg-bakery-cream cursor-pointer text-center';
        deliveryCard.querySelector('i').className = 'fa-solid fa-truck text-caramel mb-1 fs-5';
        deliveryCard.querySelector('span.small').className = 'fw-bold text-primary small d-block';

        pickupCard.className = 'card p-3 border-light bg-light cursor-pointer text-center opacity-75';
        pickupCard.querySelector('i').className = 'fa-solid fa-store text-muted mb-1 fs-5';
        pickupCard.querySelector('span.small').className = 'fw-semibold text-muted small d-block';

        deliveryTypeInput.value = 'delivery';
        const shippingFee = 15000;
        shippingFeeText.innerText = 'Rp ' + shippingFee.toLocaleString('id-ID');
        grandTotalText.innerText = 'Rp ' + (subtotal + shippingFee).toLocaleString('id-ID');

        addressSection.style.display = 'block';
        shippingAddressTextarea.setAttribute('required', 'required');
        shippingAddressTextarea.value = "{{ old('shipping_address', $user->address) }}";
    }
}
</script>
@endsection
