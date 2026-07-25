@extends('layouts.app')

@section('hide_navbar', true)
@section('hide_footer', true)

@section('content')
<div class="min-vh-100 d-flex flex-column align-items-center justify-content-center py-5 bg-bakery-cream">
    <div class="card card-figma border-0 shadow-sm p-0 overflow-hidden w-100" style="max-width: 520px;">
        <!-- Header Box (Soft Cream Yellow - Figma Screenshot 2) -->
        <div class="p-4 text-center border-bottom border-light" style="background-color: #F8F2E6;">
            <div class="rounded-circle bg-white d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 52px; height: 52px;">
                <i class="fa-solid fa-receipt text-caramel fs-4"></i>
            </div>
            <h3 class="font-serif fw-bold text-primary mb-1" style="font-size: 1.5rem;">Konfirmasi Pembayaran</h3>
            <p class="text-muted small mb-0" style="font-size: 0.82rem;">Selesaikan pembayaran Anda untuk pesanan #{{ $order->order_code }}</p>
        </div>

        <div class="p-4 p-md-4">
            @if(session('error'))
                <div class="alert alert-danger small py-2 px-3 mb-3 rounded-3" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger small py-2 px-3 mb-3 rounded-3" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Total Amount Highlight Box (Figma Screenshot 2) -->
            <div class="p-3 rounded-3 d-flex justify-content-between align-items-center mb-4" style="background-color: #FAF6ED; border: 1px solid #EADBCE;">
                <span class="text-uppercase fw-bold text-muted small" style="font-size: 0.72rem; letter-spacing: 0.5px;">TOTAL PEMBAYARAN</span>
                <span class="fw-bold text-caramel fs-4">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>

            <!-- Pilih Metode Pembayaran Tabs -->
            <div class="mb-4">
                <label class="form-label fw-bold text-primary small mb-2">Pilih Metode Pembayaran</label>
                <div class="row g-2">
                    <div class="col-6">
                        <div id="tab-bank" class="card p-2 text-center cursor-pointer" style="background-color: #FAF6ED; border: 1.5px solid #C89D7C; border-radius: 8px;" onclick="switchPaymentMethod('bank')">
                            <span class="fw-bold text-primary small"><i class="fa-solid fa-building-columns me-1 text-caramel"></i> Transfer Bank</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div id="tab-ewallet" class="card p-2 text-center cursor-pointer opacity-75" style="background-color: #FFFFFF; border: 1px solid #EADBCE; border-radius: 8px;" onclick="switchPaymentMethod('ewallet')">
                            <span class="fw-semibold text-muted small"><i class="fa-solid fa-wallet me-1"></i> E-Wallet / QRIS</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transfer Details Box (Bank) -->
            <div id="payment-bank-box" class="card p-3 rounded-3 mb-4" style="background-color: #FFFFFF; border: 1px solid #EADBCE;">
                <span class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.68rem; letter-spacing: 0.5px;">TRANSFER KE REKENING:</span>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="fw-bold text-primary mb-0">Bank BCA</h6>
                    <button type="button" class="btn btn-link text-caramel p-0 small text-decoration-none" onclick="copyNoRek('1234567890')">
                        <i class="fa-regular fa-copy me-1"></i> <span id="copy-btn-text">Salin</span>
                    </button>
                </div>
                <div class="fw-bold text-primary fs-4 mb-1">123 456 7890</div>
                <span class="text-muted small d-block mb-3" style="font-size: 0.78rem;">a.n. Toko Pesan Roti</span>

                <hr class="border-secondary opacity-25 my-2">

                <span class="fw-bold text-primary small d-block mb-2" style="font-size: 0.75rem;">INSTRUKSI TRANSFER:</span>
                <ol class="text-muted small ps-3 mb-0" style="font-size: 0.78rem; line-height: 1.6;">
                    <li>Buka aplikasi m-banking atau kunjungi ATM terdekat.</li>
                    <li>Pilih menu <strong>Transfer</strong> antar bank atau sesama BCA.</li>
                    <li>Masukkan nomor rekening <strong>123 456 7890</strong>.</li>
                    <li>Masukkan nominal persis: <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>.</li>
                    <li>Simpan bukti transfer Anda.</li>
                </ol>
            </div>

            <!-- E-Wallet / QRIS Box -->
            <div id="payment-ewallet-box" class="card p-3 rounded-3 mb-4 d-none text-center" style="background-color: #FFFFFF; border: 1px solid #EADBCE;">
                <span class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.68rem; letter-spacing: 0.5px;">SCAN QRIS / E-WALLET</span>
                <div class="p-2 bg-light rounded-3 d-inline-block mx-auto mb-2 border border-secondary-subtle">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=TOKO-PESAN-ROTI-PAYMENT-{{ $order->order_code }}" alt="QRIS Payment" class="img-fluid rounded" style="width: 160px; height: 160px;">
                </div>
                <span class="fw-bold text-primary d-block small mb-1">Gopay / OVO / DANA / ShopeePay</span>
                <span class="text-muted small d-block mb-2" style="font-size: 0.78rem;">a.n. Toko Pesan Roti (0812-3456-7890)</span>
            </div>

            <!-- Unggah Bukti Transfer Dropzone Form -->
            <form action="{{ route('orders.proof', $order->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return validatePaymentForm()">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-bold text-primary small mb-2">Unggah Bukti Pembayaran <span class="text-danger">*</span></label>
                    <div class="border border-2 border-dashed rounded-3 p-4 text-center" style="background-color: #FAF6ED; border-color: #EADBCE !important; cursor: pointer;" onclick="document.getElementById('payment_proof').click()">
                        <div id="upload-placeholder">
                            <i class="fa-solid fa-cloud-arrow-up text-caramel fs-2 mb-2"></i>
                            <span class="fw-bold text-primary d-block small mb-1">Klik untuk unggah gambar</span>
                            <span class="text-muted small d-block" style="font-size: 0.72rem;">Maksimal ukuran file 5MB (JPG, PNG, WEBP)</span>
                        </div>
                        <div id="image-preview-box" class="d-none mt-2">
                            <img id="image-preview" src="#" alt="Preview Bukti Transfer" class="img-fluid rounded border shadow-sm mb-2" style="max-height: 160px; object-fit: contain;">
                        </div>
                        <input type="file" id="payment_proof" name="payment_proof" class="d-none" accept="image/*" required onchange="previewImage(this)">
                        <div id="file-name" class="fw-bold text-success small mt-2"></div>
                    </div>
                </div>

                <!-- Action Buttons (Figma Screenshot 2) -->
                <div class="row g-2">
                    <div class="col-5">
                        <a href="{{ route('orders.index') }}" class="btn btn-caramel-outline w-100 py-2.5 text-center text-decoration-none">
                            Batal
                        </a>
                    </div>
                    <div class="col-7">
                        <button type="submit" class="btn btn-caramel w-100 py-2.5">
                            Konfirmasi Pembayaran
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function switchPaymentMethod(type) {
    const bankTab = document.getElementById('tab-bank');
    const ewalletTab = document.getElementById('tab-ewallet');
    const bankBox = document.getElementById('payment-bank-box');
    const ewalletBox = document.getElementById('payment-ewallet-box');

    if (type === 'ewallet') {
        ewalletTab.className = 'card p-2 text-center cursor-pointer';
        ewalletTab.style = 'background-color: #FAF6ED; border: 1.5px solid #C89D7C; border-radius: 8px;';
        ewalletTab.querySelector('span').className = 'fw-bold text-primary small';

        bankTab.className = 'card p-2 text-center cursor-pointer opacity-75';
        bankTab.style = 'background-color: #FFFFFF; border: 1px solid #EADBCE; border-radius: 8px;';
        bankTab.querySelector('span').className = 'fw-semibold text-muted small';

        bankBox.classList.add('d-none');
        ewalletBox.classList.remove('d-none');
    } else {
        bankTab.className = 'card p-2 text-center cursor-pointer';
        bankTab.style = 'background-color: #FAF6ED; border: 1.5px solid #C89D7C; border-radius: 8px;';
        bankTab.querySelector('span').className = 'fw-bold text-primary small';

        ewalletTab.className = 'card p-2 text-center cursor-pointer opacity-75';
        ewalletTab.style = 'background-color: #FFFFFF; border: 1px solid #EADBCE; border-radius: 8px;';
        ewalletTab.querySelector('span').className = 'fw-semibold text-muted small';

        ewalletBox.classList.add('d-none');
        bankBox.classList.remove('d-none');
    }
}

function copyNoRek(noRek) {
    navigator.clipboard.writeText(noRek);
    const copyBtnText = document.getElementById('copy-btn-text');
    copyBtnText.innerText = 'Disalin!';
    setTimeout(() => {
        copyBtnText.innerText = 'Salin';
    }, 2000);
}

function previewImage(input) {
    const file = input.files[0];
    if (file) {
        if (file.size > 5 * 1024 * 1024) {
            const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
            alert('Ukuran file gambar (' + sizeMB + ' MB) melebihi batas maksimal 5MB. Silakan gunakan foto berukuran lebih kecil.');
            input.value = '';
            document.getElementById('file-name').innerText = '';
            document.getElementById('image-preview-box').classList.add('d-none');
            return;
        }

        document.getElementById('file-name').innerText = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('image-preview');
            preview.src = e.target.result;
            document.getElementById('image-preview-box').classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    }
}

function validatePaymentForm() {
    const input = document.getElementById('payment_proof');
    if (!input.files || input.files.length === 0) {
        alert('Harap pilih dan lampirkan foto bukti pembayaran terlebih dahulu sebelum mengonfirmasi.');
        return false;
    }
    if (input.files[0].size > 5 * 1024 * 1024) {
        alert('Ukuran file melebihi batas 5MB. Silakan gunakan foto lain.');
        return false;
    }
    return true;
}
</script>
@endsection
