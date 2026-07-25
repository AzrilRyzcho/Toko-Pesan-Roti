@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
<div class="container-fluid p-0">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <!-- Top Header & Save Button (Figma Screenshot 4) -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h3 class="font-serif fw-bold text-primary mb-1">Pengaturan Website</h3>
                <p class="text-muted small mb-0">Kelola informasi umum dan preferensi operasional toko Anda.</p>
            </div>

            <button type="submit" class="btn btn-caramel px-4 py-2.5 rounded-3">
                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
            </button>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show small py-3 px-4 mb-4 rounded-3 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2 fs-5 align-middle"></i> {{ session('success') }}
                <button type="button" class="btn-close py-3" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Mode Maintenance Card (Figma Screenshot 4) -->
        <div class="card card-figma border-0 p-4 mb-4 shadow-sm" style="background-color: {{ !empty($settings['maintenance_mode']) ? '#FCE4D6' : '#FAF3E8' }}; transition: all 0.3s ease;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle p-2 {{ !empty($settings['maintenance_mode']) ? 'text-danger bg-white' : 'text-caramel bg-white' }} shadow-sm d-flex align-items-center justify-content-center" style="width: 46px; height: 46px;">
                        <i class="fa-solid fa-screwdriver-wrench fs-4"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h6 class="fw-bold text-primary mb-0">Mode Maintenance</h6>
                            @if(!empty($settings['maintenance_mode']))
                                <span class="badge bg-danger px-2.5 py-1">AKTIF (PELANGGAN DIBLOKIR)</span>
                            @else
                                <span class="badge bg-secondary px-2.5 py-1">NONAKTIF (NORMAL)</span>
                            @endif
                        </div>
                        <p class="text-muted small mb-0" style="font-size: 0.78rem; max-width: 620px; line-height: 1.5;">
                            Aktifkan untuk menyembunyikan website dari pelanggan sementara Anda melakukan perbaikan atau pembaruan besar. Admin tetap dapat mengakses dashboard secara normal.
                        </p>
                    </div>
                </div>

                <div class="form-check form-switch fs-3 me-2">
                    <input class="form-check-input cursor-pointer" type="checkbox" role="switch" id="maintenance_mode" name="maintenance_mode" value="1" {{ !empty($settings['maintenance_mode']) ? 'checked' : '' }}>
                </div>
            </div>
        </div>

        <!-- Main Settings 2 Columns (Figma Screenshot 4) -->
        <div class="row g-4 mb-4">
            <!-- Left Column: Informasi Umum -->
            <div class="col-lg-7">
                <div class="card card-figma border-0 p-4 shadow-sm h-100">
                    <h5 class="font-serif fw-bold text-primary mb-4 border-bottom border-light pb-2 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-store text-caramel"></i> Informasi Umum
                    </h5>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary small">Nama Toko</label>
                        <input type="text" name="store_name" class="form-control form-control-figma" value="{{ old('store_name', $settings['store_name'] ?? 'Toko Pesan Roti') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary small">Deskripsi Singkat</label>
                        <textarea name="store_description" class="form-control form-control-figma" rows="2" style="height: 70px;">{{ old('store_description', $settings['store_description'] ?? '') }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-primary small">Email Kontak</label>
                            <input type="email" name="contact_email" class="form-control form-control-figma" value="{{ old('contact_email', $settings['contact_email'] ?? 'halo@tokopesanroti.com') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-primary small">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp_number" class="form-control form-control-figma" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '+62 812-3456-7890') }}" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold text-primary small">Alamat Lengkap Toko</label>
                        <textarea name="store_address" class="form-control form-control-figma" rows="3" style="height: 80px;" required>{{ old('store_address', $settings['store_address'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column: Jam Operasional -->
            <div class="col-lg-5">
                <div class="card card-figma border-0 p-4 shadow-sm h-100">
                    <h5 class="font-serif fw-bold text-primary mb-4 border-bottom border-light pb-2 d-flex align-items-center gap-2">
                        <i class="fa-regular fa-clock text-caramel"></i> Jam Operasional
                    </h5>

                    @php
                        $days = [
                            'Senin' => ['08:00 AM', '08:00 PM'],
                            'Selasa' => ['08:00 AM', '08:00 PM'],
                            'Rabu' => ['08:00 AM', '08:00 PM'],
                            'Kamis' => ['08:00 AM', '08:00 PM'],
                            'Jumat' => ['08:00 AM', '08:00 PM'],
                            'Sabtu' => ['09:00 AM', '09:00 PM'],
                            'Minggu' => ['09:00 AM', '06:00 PM'],
                        ];
                    @endphp

                    <div class="d-flex flex-column gap-2">
                        @foreach($days as $day => $times)
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-bold text-primary small" style="width: 70px;">{{ $day }}</span>
                                <div class="d-flex align-items-center gap-1">
                                    <input type="text" class="form-control form-control-sm text-center border-secondary-subtle bg-bakery-cream fw-semibold" style="width: 90px;" value="{{ $times[0] }}">
                                    <span class="text-muted small">-</span>
                                    <input type="text" class="form-control form-control-sm text-center border-secondary-subtle bg-bakery-cream fw-semibold" style="width: 90px;" value="{{ $times[1] }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Card: Biaya Pengiriman (Figma Screenshot 4) -->
        <div class="card card-figma border-0 p-4 shadow-sm">
            <h5 class="font-serif fw-bold text-primary mb-4 border-bottom border-light pb-2 d-flex align-items-center gap-2">
                <i class="fa-solid fa-truck text-caramel"></i> Biaya Pengiriman
            </h5>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-primary small">Biaya Pengiriman Dasar (Rp)</label>
                    <input type="number" name="shipping_fee" class="form-control form-control-figma" value="{{ old('shipping_fee', $settings['shipping_fee'] ?? 15000) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-primary small">Batas Jarak Gratis Ongkir (km)</label>
                    <input type="number" name="free_shipping_km" class="form-control form-control-figma" value="{{ old('free_shipping_km', $settings['free_shipping_km'] ?? 5) }}" required>
                    <span class="text-muted small d-block mt-1" style="font-size: 0.7rem;">Isi 0 jika tidak ada gratis ongkir.</span>
                </div>
            </div>

            <div class="mb-2">
                <label class="form-label fw-bold text-primary small">Catatan Pengiriman</label>
                <textarea name="shipping_notes" class="form-control form-control-figma" rows="2" style="height: 70px;">{{ old('shipping_notes', $settings['shipping_notes'] ?? '') }}</textarea>
            </div>
        </div>
    </form>
</div>
@endsection
