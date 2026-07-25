@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <!-- Left Sidebar Card (Figma Design) -->
        <div class="col-lg-3">
            <div class="card card-figma border-0 p-4 shadow-sm text-center mb-4">
                @php
                    $avatar = $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=200';
                @endphp
                <img src="{{ $avatar }}" class="rounded-circle mx-auto mb-3 border border-light" alt="Avatar" style="width: 72px; height: 72px; object-fit: cover;">
                <h6 class="font-serif fw-bold text-primary mb-0">{{ $user->name }}</h6>
                <span class="text-muted small d-block mb-3" style="font-size: 0.75rem;">Member sejak {{ $user->created_at->format('Y') }}</span>

                <!-- Navigation List -->
                <div class="d-flex flex-column gap-1 text-start">
                    <a href="{{ route('profile.edit') }}" class="profile-nav-link active">
                        <i class="fa-regular fa-user me-2"></i> Profil Saya
                    </a>
                    <a href="{{ route('orders.index') }}" class="profile-nav-link">
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

        <!-- Right Main Content Area -->
        <div class="col-lg-9">
            <!-- Flash Message Alert -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show small py-2 px-3 mb-4 rounded-3" role="alert">
                    <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Section 1: Informasi Profil Card -->
            <div class="card card-figma border-0 p-4 p-md-5 mb-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-4 border-bottom border-light pb-3">
                    <div>
                        <h4 class="font-serif fw-bold text-primary mb-1">Informasi Profil</h4>
                        <p class="text-muted small mb-0">Kelola detail pribadi dan preferensi akun Anda.</p>
                    </div>
                    <button class="btn btn-caramel btn-sm py-2 px-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fa-solid fa-pen me-1"></i> Edit Profil
                    </button>
                </div>

                <!-- Grid 2x2 Information -->
                <div class="row g-4">
                    <div class="col-sm-6">
                        <span class="text-muted text-uppercase fw-semibold d-block mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">NAMA LENGKAP</span>
                        <span class="fw-bold text-primary fs-6">{{ $user->name }}</span>
                    </div>

                    <div class="col-sm-6">
                        <span class="text-muted text-uppercase fw-semibold d-block mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">EMAIL</span>
                        <span class="fw-bold text-primary fs-6">{{ $user->email }}</span>
                    </div>

                    <div class="col-sm-6">
                        <span class="text-muted text-uppercase fw-semibold d-block mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">NOMOR TELEPON</span>
                        <span class="fw-bold text-primary fs-6">{{ $user->phone ?: 'Belum diisi' }}</span>
                    </div>

                    <div class="col-sm-6">
                        <span class="text-muted text-uppercase fw-semibold d-block mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">TANGGAL BERGABUNG</span>
                        <span class="fw-bold text-primary fs-6">{{ $user->created_at->format('d F Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Section 2: Alamat Pengiriman Card -->
            <div class="card card-figma border-0 p-4 p-md-5 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-light pb-3">
                    <h5 class="font-serif fw-bold text-primary mb-0">Alamat Pengiriman</h5>
                    <button class="btn btn-link text-caramel text-decoration-none small fw-semibold p-0" data-bs-toggle="modal" data-bs-target="#editAddressModal">
                        + {{ $user->address ? 'Ubah Alamat' : 'Tambah Alamat' }}
                    </button>
                </div>

                <!-- Address Box Card -->
                <div class="p-4 rounded-3 mb-2" style="background-color: #FAF6ED; border: 1px solid #EADBCE;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="font-serif fw-bold text-primary mb-0"><i class="fa-solid fa-location-dot text-caramel me-2"></i>Alamat Utama ({{ $user->name }})</h6>
                        <span class="badge text-dark fw-semibold" style="background-color: #F3EBDD; color: #593E22; font-size: 0.65rem;">Utama</span>
                    </div>
                    <p class="text-muted small mb-3" style="font-size: 0.88rem; line-height: 1.6;">
                        {{ $user->address ?: 'Belum ada alamat pengiriman yang disimpan. Silakan klik tombol Ubah/Tambah Alamat untuk melengkapi alamat pengiriman Anda.' }}
                    </p>
                    <a href="#" class="text-caramel small text-decoration-none fw-semibold" data-bs-toggle="modal" data-bs-target="#editAddressModal">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Ubah Alamat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-figma border-0 p-3">
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <h4 class="font-serif fw-bold text-primary mb-1">Edit Profil</h4>
                    <p class="text-muted small">Perbarui informasi data diri Anda di bawah ini.</p>
                </div>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <!-- Nama Lengkap -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-primary small">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="form-control form-control-figma" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <!-- Alamat Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-primary small">Alamat Email</label>
                        <input type="email" id="email" name="email" class="form-control form-control-figma" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="mb-4">
                        <label for="phone" class="form-label fw-semibold text-primary small">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" class="form-control form-control-figma" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890">
                    </div>

                    <input type="hidden" name="address" value="{{ $user->address }}">

                    <!-- Action Buttons -->
                    <div class="row g-2">
                        <div class="col-5">
                            <button type="button" class="btn btn-caramel-outline w-100 py-3" data-bs-dismiss="modal">
                                Batal
                            </button>
                        </div>
                        <div class="col-7">
                            <button type="submit" class="btn btn-caramel w-100 py-3">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ubah Alamat Pengiriman -->
<div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-figma border-0 p-3">
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <h4 class="font-serif fw-bold text-primary mb-1">Alamat Pengiriman</h4>
                    <p class="text-muted small">Kelola dan perbarui alamat lengkap pengiriman roti Anda.</p>
                </div>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <input type="hidden" name="phone" value="{{ $user->phone }}">

                    <!-- Alamat Lengkap -->
                    <div class="mb-4">
                        <label for="modal_address" class="form-label fw-semibold text-primary small">Alamat Lengkap Pengiriman</label>
                        <textarea id="modal_address" name="address" class="form-control form-control-figma p-3" rows="4" style="height: 120px;" placeholder="Masukkan nama jalan, nomor rumah, RT/RW, Kecamatan, Kota, dan Kode Pos..." required>{{ old('address', $user->address) }}</textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row g-2">
                        <div class="col-5">
                            <button type="button" class="btn btn-caramel-outline w-100 py-3" data-bs-dismiss="modal">
                                Batal
                            </button>
                        </div>
                        <div class="col-7">
                            <button type="submit" class="btn btn-caramel w-100 py-3">
                                Simpan Alamat
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
