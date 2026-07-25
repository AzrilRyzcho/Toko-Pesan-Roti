@extends('layouts.admin')

@section('title', 'Pemantauan Stok')

@section('content')
<div class="container-fluid p-0">
    <!-- Subtitle Description -->
    <div class="mb-4">
        <p class="text-muted small mb-0">Pantau dan perbarui stok batch roti secara real-time.</p>
    </div>

    <!-- Top 3 Metric Cards (Compact Layout) -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card card-figma border-0 p-3 shadow-sm h-100">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="text-uppercase fw-bold text-muted" style="font-size: 0.65rem; letter-spacing: 0.5px;">TOTAL VARIAN</span>
                    <div class="rounded-3 p-1.5 text-caramel d-flex align-items-center justify-content-center flex-shrink-0" style="background-color: #FAF3E8; width: 34px; height: 34px;">
                        <i class="fa-solid fa-shapes" style="font-size: 0.9rem;"></i>
                    </div>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.35rem; line-height: 1.25;">{{ $totalProductsCount ?? 48 }}</h4>
                </div>
                <div class="mt-1.5">
                    <span class="text-muted" style="font-size: 0.72rem;">Semua varian terdaftar</span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-figma border-0 p-3 shadow-sm h-100" style="border-left: 4px solid #C89D7C !important;">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="text-uppercase fw-bold text-caramel" style="font-size: 0.65rem; letter-spacing: 0.5px;">STOK MENIPIS</span>
                    <div class="rounded-3 p-1.5 text-warning bg-warning-subtle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 34px; height: 34px;">
                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 0.9rem;"></i>
                    </div>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.35rem; line-height: 1.25;">{{ $lowStockProductsCount ?? 12 }}</h4>
                </div>
                <div class="mt-1.5">
                    <span class="text-muted" style="font-size: 0.72rem;">Butuh produksi segera</span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-figma border-0 p-3 shadow-sm h-100">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="text-uppercase fw-bold text-muted" style="font-size: 0.65rem; letter-spacing: 0.5px;">DIPERBARUI HARI INI</span>
                    <div class="rounded-3 p-1.5 text-success bg-success-subtle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 34px; height: 34px;">
                        <i class="fa-solid fa-rotate" style="font-size: 0.9rem;"></i>
                    </div>
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.35rem; line-height: 1.25;">156</h4>
                </div>
                <div class="mt-1.5">
                    <span class="text-muted" style="font-size: 0.72rem;">Siklus batch pagi</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Row: Stock Table & History Timeline -->
    <div class="row g-4">
        <!-- Left Table -->
        <div class="col-lg-8">
            <div class="card card-figma border-0 shadow-sm p-4 d-flex flex-column justify-content-between" style="min-height: 520px;">
                <!-- Search & Filters (Uniform Buttons) -->
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <form action="{{ route('admin.stock.index') }}" method="GET" class="d-flex align-items-center gap-2">
                        @if(request('filter'))
                            <input type="hidden" name="filter" value="{{ request('filter') }}">
                        @endif
                        <div class="input-group" style="width: 240px;">
                            <span class="input-group-text bg-bakery-cream border-secondary-subtle text-muted">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-bakery-cream border-secondary-subtle small" placeholder="Cari nama roti...">
                        </div>
                    </form>

                    <!-- Both Buttons With Identical Height, Padding, Font & Border Radius -->
                    <div class="d-flex align-items-center gap-2">
                        @php $isLow = request('filter') === 'low'; @endphp
                        
                        <a href="{{ route('admin.stock.index') }}" class="btn btn-sm d-inline-flex align-items-center justify-content-center gap-1.5" style="height: 36px; padding: 6px 18px; font-size: 0.82rem; border-radius: 8px; {{ !$isLow ? 'background-color: #4A3319; color: #FFFFFF !important; font-weight: 700; border: 1px solid #4A3319;' : 'background-color: #FFFDF5; color: #8C735C; font-weight: 600; border: 1px solid #EADBCE;' }}">
                            <i class="fa-solid fa-filter" style="font-size: 0.78rem;"></i> Semua
                        </a>

                        <a href="{{ route('admin.stock.index', ['filter' => 'low']) }}" class="btn btn-sm d-inline-flex align-items-center justify-content-center gap-1.5" style="height: 36px; padding: 6px 18px; font-size: 0.82rem; border-radius: 8px; {{ $isLow ? 'background-color: #4A3319; color: #FFFFFF !important; font-weight: 700; border: 1px solid #4A3319;' : 'background-color: #FFFDF5; color: #8C735C; font-weight: 600; border: 1px solid #EADBCE;' }}">
                            Menipis (&lt; 10)
                        </a>
                    </div>
                </div>

                <!-- Stock Table -->
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="bg-bakery-cream text-uppercase text-muted" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                            <tr>
                                <th>PRODUK</th>
                                <th>KATEGORI</th>
                                <th>STATUS</th>
                                <th class="text-center">SISA STOK</th>
                                <th class="text-end">UPDATE CEPAT</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y border-top-0">
                            @forelse($products as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded overflow-hidden" style="width: 38px; height: 38px;">
                                                @php
                                                    if (str_starts_with($product->image ?? '', 'http')) {
                                                        $stockImg = $product->image;
                                                    } elseif ($product->image) {
                                                        $stockImg = str_starts_with($product->image, 'images/') ? asset($product->image) : asset('storage/' . $product->image);
                                                    } else {
                                                        $stockImg = 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=200';
                                                    }
                                                @endphp
                                                <img src="{{ $stockImg }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $product->name }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800';">
                                            </div>
                                            <div>
                                                <span class="fw-bold text-primary small d-block mb-0">{{ $product->name }}</span>
                                                <span class="text-muted" style="font-size: 0.68rem;">Batch Pagi</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="small text-muted">{{ $product->category->name ?? '-' }}</td>
                                    <td>
                                        @if($product->stock <= 10)
                                            <span class="badge py-1 px-2.5 rounded-pill" style="background-color: #FFF2CC; color: #7F6000; font-size: 0.68rem;">MENIPIS</span>
                                        @else
                                            <span class="badge py-1 px-2.5 rounded-pill" style="background-color: #E2F0D9; color: #385723; font-size: 0.68rem;">AMAN</span>
                                        @endif
                                    </td>
                                    <td class="text-center fw-bold text-caramel fs-5" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $product->stock }}</td>
                                    <td class="text-end">
                                        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="d-inline-flex gap-1 align-items-center justify-content-end">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="name" value="{{ $product->name }}">
                                            <input type="hidden" name="price" value="{{ $product->price }}">
                                            <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                                            <input type="number" name="stock" value="{{ $product->stock + 10 }}" class="form-control form-control-sm text-center" style="width: 60px;">
                                            <button type="submit" class="btn btn-caramel btn-sm py-1 px-2.5 text-nowrap">+10 Stok</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Tidak ada data produk yang ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

        <!-- Right Timeline: Riwayat Terakhir -->
        <div class="col-lg-4">
            <div class="card card-figma border-0 shadow-sm p-4 h-100">
                <h6 class="font-serif fw-bold text-primary mb-3 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-caramel"></i> Riwayat Terakhir
                </h6>

                <div class="timeline position-relative ps-3 my-2 border-start border-2 border-light">
                    <!-- Event 1 -->
                    <div class="mb-4 position-relative ps-3">
                        <span class="position-absolute top-0 start-0 translate-middle rounded-circle bg-success text-white p-1" style="left: -17px !important; width: 22px; height: 22px; font-size: 0.6rem; display: flex; align-items: center; justify-content: center;">+</span>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary small">+20 Pain au Chocolat</span>
                            <span class="text-muted" style="font-size: 0.68rem;">10:42</span>
                        </div>
                        <p class="text-muted small mb-0" style="font-size: 0.72rem;">Ditambah oleh Budi (Produksi Pagi)</p>
                    </div>

                    <!-- Event 2 -->
                    <div class="mb-4 position-relative ps-3">
                        <span class="position-absolute top-0 start-0 translate-middle rounded-circle bg-danger text-white p-1" style="left: -17px !important; width: 22px; height: 22px; font-size: 0.6rem; display: flex; align-items: center; justify-content: center;">-</span>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary small">-5 Sourdough</span>
                            <span class="text-muted" style="font-size: 0.68rem;">09:15</span>
                        </div>
                        <p class="text-muted small mb-0" style="font-size: 0.72rem;">Penyesuaian manual (Rusak)</p>
                    </div>

                    <!-- Event 3 -->
                    <div class="mb-2 position-relative ps-3">
                        <span class="position-absolute top-0 start-0 translate-middle rounded-circle bg-warning text-dark p-1" style="left: -17px !important; width: 22px; height: 22px; font-size: 0.6rem; display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-bag-shopping"></i></span>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary small">-2 Roti Susu</span>
                            <span class="text-muted" style="font-size: 0.68rem;">08:30</span>
                        </div>
                        <p class="text-muted small mb-0" style="font-size: 0.72rem;">Pesanan #ORD-992</p>
                    </div>
                </div>

                <!-- Modal Trigger Button -->
                <button type="button" class="btn btn-caramel-outline w-100 py-2 mt-auto small" data-bs-toggle="modal" data-bs-target="#stockLogModal">
                    Lihat Semua Log
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Stock Log -->
<div class="modal fade" id="stockLogModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom border-light">
                <h5 class="modal-title font-serif fw-bold text-primary">Log Aktivitas Stok Terakhir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="table-responsive">
                    <table class="table align-middle table-hover small mb-0">
                        <thead class="bg-bakery-cream text-uppercase text-muted" style="font-size: 0.72rem;">
                            <tr>
                                <th>WAKTU</th>
                                <th>PRODUK</th>
                                <th>PERUBAHAN</th>
                                <th>KETERANGAN</th>
                                <th>OPERATOR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-muted">Hari Ini, 10:42</td>
                                <td class="fw-bold text-primary">Pain au Chocolat</td>
                                <td><span class="badge bg-success">+20 Pcs</span></td>
                                <td>Batch Produksi Pagi</td>
                                <td>Budi Haryanto</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Hari Ini, 09:15</td>
                                <td class="fw-bold text-primary">Sourdough Classic</td>
                                <td><span class="badge bg-danger">-5 Pcs</span></td>
                                <td>Penyesuaian Kerusakan</td>
                                <td>Admin Roti</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Hari Ini, 08:30</td>
                                <td class="fw-bold text-primary">Roti Susu Keju</td>
                                <td><span class="badge bg-warning text-dark">-2 Pcs</span></td>
                                <td>Penjualan #ORD-992</td>
                                <td>Sistem Otomatis</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Kemarin, 16:00</td>
                                <td class="fw-bold text-primary">Belgian Chocolate Fudge</td>
                                <td><span class="badge bg-success">+15 Pcs</span></td>
                                <td>Batch Produksi Sore</td>
                                <td>Budi Haryanto</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-caramel btn-sm px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection
