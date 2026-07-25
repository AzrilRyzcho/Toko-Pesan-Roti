@extends('layouts.admin')

@section('title', 'Daftar Pelanggan')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Row (Figma Screenshot 3) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="font-serif fw-bold text-primary mb-1">Daftar Pelanggan</h3>
            <p class="text-muted small mb-0">Kelola data pelanggan dan status akun mereka.</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Search Bar Form -->
            <form action="{{ route('admin.customers.index') }}" method="GET" class="d-flex">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                @if(request('order_filter'))
                    <input type="hidden" name="order_filter" value="{{ request('order_filter') }}">
                @endif
                <div class="input-group" style="width: 260px;">
                    <span class="input-group-text bg-white border-secondary-subtle text-muted">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" class="form-control bg-white border-secondary-subtle small" placeholder="Cari nama, email, hp..." value="{{ request('search') }}">
                </div>
            </form>
        </div>
    </div>

    <!-- Session Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show small py-2 px-3 mb-3 rounded-3" role="alert">
            <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter & Export Buttons Row (Figma Screenshot 3) -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-2 align-items-center">
            <!-- Filter Dropdown -->
            <div class="dropdown">
                <button class="btn btn-white bg-white border-secondary-subtle btn-sm text-primary px-3 dropdown-toggle shadow-sm fw-semibold" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-sliders me-1 text-caramel"></i> 
                    @if(request('status') === 'active')
                        Status: Aktif
                    @elseif(request('status') === 'inactive')
                        Status: Nonaktif
                    @elseif(request('order_filter') === 'has_orders')
                        Pernah Memesan
                    @elseif(request('order_filter') === 'no_orders')
                        Belum Memesan
                    @else
                        Filter Pelanggan
                    @endif
                </button>
                <ul class="dropdown-menu border-0 shadow">
                    <li><h6 class="dropdown-header text-uppercase text-muted" style="font-size: 0.68rem;">Status Akun</h6></li>
                    <li>
                        <a class="dropdown-item small {{ !request('status') && !request('order_filter') ? 'fw-bold active' : '' }}" href="{{ route('admin.customers.index', request()->only('search')) }}">
                            Semua Pelanggan
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item small text-success {{ request('status') === 'active' ? 'fw-bold active' : '' }}" href="{{ route('admin.customers.index', array_merge(request()->except('status'), ['status' => 'active'])) }}">
                            <i class="fa-solid fa-circle-check me-1"></i> Status: Aktif
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item small text-danger {{ request('status') === 'inactive' ? 'fw-bold active' : '' }}" href="{{ route('admin.customers.index', array_merge(request()->except('status'), ['status' => 'inactive'])) }}">
                            <i class="fa-solid fa-circle-xmark me-1"></i> Status: Nonaktif (Diblokir)
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><h6 class="dropdown-header text-uppercase text-muted" style="font-size: 0.68rem;">Riwayat Transaksi</h6></li>
                    <li>
                        <a class="dropdown-item small {{ request('order_filter') === 'has_orders' ? 'fw-bold active' : '' }}" href="{{ route('admin.customers.index', array_merge(request()->except('order_filter'), ['order_filter' => 'has_orders'])) }}">
                            Pernah Memesan
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item small {{ request('order_filter') === 'no_orders' ? 'fw-bold active' : '' }}" href="{{ route('admin.customers.index', array_merge(request()->except('order_filter'), ['order_filter' => 'no_orders'])) }}">
                            Belum Pernah Memesan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Export CSV Button -->
            <a href="{{ route('admin.customers.export', request()->all()) }}" class="btn btn-white bg-white border-secondary-subtle btn-sm text-primary px-3 shadow-sm text-decoration-none fw-semibold">
                <i class="fa-solid fa-download me-1 text-caramel"></i> Ekspor CSV
            </a>

            @if(request('status') || request('order_filter') || request('search'))
                <a href="{{ route('admin.customers.index') }}" class="btn btn-sm btn-outline-secondary px-2 py-1 rounded-2 text-decoration-none small">
                    <i class="fa-solid fa-rotate-left me-1"></i> Reset
                </a>
            @endif
        </div>

        <span class="text-muted small" style="font-size: 0.78rem;">
            Menampilkan {{ $customers->firstItem() ?? 1 }}-{{ $customers->lastItem() ?? $customers->count() }} dari {{ $customers->total() }} Pelanggan
        </span>
    </div>

    <!-- Customers Table Card (Clean HTML Table) -->
    <div class="card card-figma border-0 shadow-sm p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="bg-bakery-cream text-uppercase text-muted" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                    <tr>
                        <th class="ps-4 py-3">PROFIL</th>
                        <th class="py-3">KONTAK</th>
                        <th class="py-3">TOTAL PESANAN</th>
                        <th class="py-3">BERGABUNG</th>
                        <th class="py-3">STATUS</th>
                        <th class="text-end pe-4 py-3">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-top-0">
                    @forelse($customers as $customer)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    @php
                                        $avatar = $customer->profile_photo ? asset('storage/' . $customer->profile_photo) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=150';
                                    @endphp
                                    <img src="{{ $avatar }}" class="rounded-circle border" style="width: 42px; height: 42px; object-fit: cover;">
                                    <div>
                                        <span class="fw-bold text-primary d-block mb-0">{{ $customer->name }}</span>
                                        <span class="text-muted" style="font-size: 0.7rem;">ID: #CUST-00{{ $customer->id }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="d-block text-primary small mb-0">{{ $customer->email }}</span>
                                <span class="text-muted" style="font-size: 0.7rem;">{{ $customer->phone ?: 'Tidak ada no. hp' }}</span>
                            </td>
                            <td class="py-3">
                                <span class="fw-bold text-primary small d-block mb-0">{{ $customer->orders->count() }} Pesanan</span>
                                <span class="text-muted" style="font-size: 0.7rem;">Rp {{ number_format($customer->orders->sum('total_amount'), 0, ',', '.') }}</span>
                            </td>
                            <td class="py-3">
                                <span class="d-block text-primary small mb-0">{{ $customer->created_at->format('d M Y') }}</span>
                                <span class="text-muted" style="font-size: 0.7rem;">{{ $customer->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="py-3">
                                @if($customer->is_active ?? true)
                                    <span class="badge py-1.5 px-3 rounded-pill" style="background-color: #E2F0D9; color: #385723;">Aktif</span>
                                @else
                                    <span class="badge py-1.5 px-3 rounded-pill" style="background-color: #FCE4D6; color: #C65911;">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end pe-4 py-3">
                                <!-- Eye Button: View Profile Modal -->
                                <button type="button" class="btn btn-link text-muted p-1 border-0 me-1" data-bs-toggle="modal" data-bs-target="#customerModal_{{ $customer->id }}" title="Lihat Profil">
                                    <i class="fa-regular fa-eye fs-6 text-caramel"></i>
                                </button>

                                <!-- Ban / Toggle Status Form Button -->
                                <form action="{{ route('admin.customers.toggle-status', $customer->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ ($customer->is_active ?? true) ? 'Apakah Anda yakin ingin menonaktifkan/membokir akun ' . $customer->name . '?' : 'Aktifkan kembali akun ' . $customer->name . '?' }}')">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-1 border-0 {{ ($customer->is_active ?? true) ? 'text-danger' : 'text-success' }}" title="{{ ($customer->is_active ?? true) ? 'Blokir Akun' : 'Aktifkan Akun' }}">
                                        <i class="fa-solid {{ ($customer->is_active ?? true) ? 'fa-ban' : 'fa-lock-open' }} fs-6"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada pelanggan terdaftar yang sesuai filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-3 bg-white d-flex justify-content-center border-top border-light">
            {{ $customers->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Modals Container (Placed Outside Table to Prevent HTML Layout Break) -->
@foreach($customers as $customer)
    @php
        $avatar = $customer->profile_photo ? asset('storage/' . $customer->profile_photo) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=150';
    @endphp
    <div class="modal fade" id="customerModal_{{ $customer->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Modal Header -->
                <div class="modal-header bg-bakery-cream border-bottom p-4">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ $avatar }}" class="rounded-circle border" style="width: 54px; height: 54px; object-fit: cover;">
                        <div>
                            <h5 class="modal-title font-serif fw-bold text-primary mb-0">{{ $customer->name }}</h5>
                            <span class="text-muted small">ID: #CUST-00{{ $customer->id }} &bull; Bergabung {{ $customer->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-light border text-center">
                                <span class="text-muted d-block small mb-1">TOTAL PESANAN</span>
                                <h5 class="fw-bold text-primary mb-0">{{ $customer->orders->count() }} Pesanan</h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-light border text-center">
                                <span class="text-muted d-block small mb-1">TOTAL PENGELUARAN</span>
                                <h5 class="fw-bold text-caramel mb-0">Rp {{ number_format($customer->orders->sum('total_amount'), 0, ',', '.') }}</h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-light border text-center">
                                <span class="text-muted d-block small mb-1">STATUS AKUN</span>
                                @if($customer->is_active ?? true)
                                    <span class="badge bg-success px-3 py-1 mt-1">Aktif</span>
                                @else
                                    <span class="badge bg-danger px-3 py-1 mt-1">Nonaktif (Diblokir)</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Contact & Address Details -->
                    <div class="card p-3 border-0 bg-bakery-cream rounded-3 mb-4">
                        <h6 class="fw-bold text-primary small mb-2"><i class="fa-solid fa-address-card text-caramel me-1"></i> Informasi Kontak</h6>
                        <div class="row g-2 small text-muted">
                            <div class="col-sm-6"><strong>Email:</strong> {{ $customer->email }}</div>
                            <div class="col-sm-6"><strong>No. Telepon:</strong> {{ $customer->phone ?: '-' }}</div>
                            <div class="col-12"><strong>Alamat Utama:</strong> {{ $customer->address ?: 'Belum diisi oleh pelanggan' }}</div>
                        </div>
                    </div>

                    <!-- Order History Table -->
                    <h6 class="fw-bold text-primary small mb-2"><i class="fa-solid fa-receipt text-caramel me-1"></i> Riwayat Pesanan Pelanggan</h6>
                    <div class="table-responsive border rounded-3">
                        <table class="table align-middle table-hover mb-0 small">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th>KODE PESANAN</th>
                                    <th>TANGGAL</th>
                                    <th>TOTAL</th>
                                    <th>STATUS PESANAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->orders->take(5) as $ord)
                                    <tr>
                                        <td class="fw-bold text-primary">#{{ $ord->order_code }}</td>
                                        <td>{{ $ord->created_at->format('d M Y H:i') }}</td>
                                        <td class="fw-bold text-caramel">Rp {{ number_format($ord->total_amount, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ strtoupper($ord->status) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">Pelanggan belum pernah melakukan pemesanan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light border-top p-3">
                    <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
