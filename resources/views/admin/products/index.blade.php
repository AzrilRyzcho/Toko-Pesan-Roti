@extends('layouts.admin')

@section('title', '')

@section('content')
<div class="container-fluid p-0">
    <!-- Top Header Row (Figma Screenshot 4) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="font-serif fw-bold text-primary mb-1">Kelola Produk</h3>
            <p class="text-muted small mb-0">Atur katalog produk, stok, dan harga toko roti Anda.</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Search Bar -->
            <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex">
                <div class="input-group" style="width: 220px;">
                    <span class="input-group-text bg-white border-secondary-subtle text-muted">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" class="form-control bg-white border-secondary-subtle small" placeholder="Cari produk..." value="{{ request('search') }}">
                </div>
            </form>

            <!-- Caramel Button + Tambah Produk Baru -->
            <a href="{{ route('admin.products.create') }}" class="btn btn-caramel px-3 py-2 rounded-3 text-nowrap">
                <i class="fa-solid fa-plus me-1"></i> Tambah Produk Baru
            </a>
        </div>
    </div>

    <!-- Filter Pills Row (Figma Screenshot 4) -->
    <div class="d-flex align-items-center gap-2 mb-3">
        <!-- Category Filter Dropdown -->
        @php
            $selectedCategory = $categories->firstWhere('id', request('category'));
            $categoryLabel = $selectedCategory ? $selectedCategory->name : 'Semua Kategori';
        @endphp
        <div class="dropdown">
            <button class="btn btn-white bg-white border-secondary-subtle btn-sm text-primary dropdown-toggle px-3 fw-semibold shadow-sm" type="button" data-bs-toggle="dropdown">
                <i class="fa-solid fa-layer-group me-1 text-caramel"></i> {{ $categoryLabel }}
            </button>
            <ul class="dropdown-menu border-0 shadow">
                <li>
                    <a class="dropdown-item small {{ !request('category') ? 'fw-bold active' : '' }}" href="{{ route('admin.products.index', request()->except(['category', 'page'])) }}">
                        Semua Kategori
                    </a>
                </li>
                @foreach($categories as $cat)
                    <li>
                        <a class="dropdown-item small {{ request('category') == $cat->id ? 'fw-bold active' : '' }}" href="{{ route('admin.products.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->id])) }}">
                            {{ $cat->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Stock Status Filter Dropdown -->
        @php
            $stockStatusMap = [
                'available' => 'Tersedia',
                'low' => 'Menipis (< 5)',
                'out_of_stock' => 'Habis (0)',
            ];
            $stockLabel = isset($stockStatusMap[request('stock_status')]) ? $stockStatusMap[request('stock_status')] : 'Status Stok';
        @endphp
        <div class="dropdown">
            <button class="btn btn-white bg-white border-secondary-subtle btn-sm text-primary dropdown-toggle px-3 fw-semibold shadow-sm" type="button" data-bs-toggle="dropdown">
                <i class="fa-solid fa-boxes-stacked me-1 text-caramel"></i> {{ $stockLabel }}
            </button>
            <ul class="dropdown-menu border-0 shadow">
                <li>
                    <a class="dropdown-item small {{ !request('stock_status') ? 'fw-bold active' : '' }}" href="{{ route('admin.products.index', request()->except(['stock_status', 'page'])) }}">
                        Semua Status
                    </a>
                </li>
                <li>
                    <a class="dropdown-item small text-success {{ request('stock_status') === 'available' ? 'fw-bold active' : '' }}" href="{{ route('admin.products.index', array_merge(request()->except(['stock_status', 'page']), ['stock_status' => 'available'])) }}">
                        <i class="fa-solid fa-circle-check me-1"></i> Tersedia
                    </a>
                </li>
                <li>
                    <a class="dropdown-item small text-warning {{ request('stock_status') === 'low' ? 'fw-bold active' : '' }}" href="{{ route('admin.products.index', array_merge(request()->except(['stock_status', 'page']), ['stock_status' => 'low'])) }}">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Menipis (&lt; 5)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item small text-danger {{ request('stock_status') === 'out_of_stock' ? 'fw-bold active' : '' }}" href="{{ route('admin.products.index', array_merge(request()->except(['stock_status', 'page']), ['stock_status' => 'out_of_stock'])) }}">
                        <i class="fa-solid fa-circle-xmark me-1"></i> Habis (0)
                    </a>
                </li>
            </ul>
        </div>

        @if(request('category') || request('stock_status') || request('search'))
            <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary px-2 py-1 rounded-2 text-decoration-none small">
                <i class="fa-solid fa-rotate-left me-1"></i> Reset Filter
            </a>
        @endif

        <span class="ms-auto text-muted small" style="font-size: 0.78rem;">
            Menampilkan {{ $products->firstItem() ?? 1 }}-{{ $products->lastItem() ?? $products->count() }} dari {{ $products->total() }} produk
        </span>
    </div>

    <!-- Product Table Card (Figma Screenshot 4) -->
    <div class="card card-figma border-0 shadow-sm p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="bg-bakery-cream text-uppercase text-muted" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                    <tr>
                        <th class="ps-4 py-3">FOTO</th>
                        <th class="py-3">NAMA PRODUK</th>
                        <th class="py-3">KATEGORI</th>
                        <th class="py-3">HARGA</th>
                        <th class="py-3">STOK</th>
                        <th class="text-end pe-4 py-3">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-top-0">
                    @forelse($products as $product)
                        <tr>
                            <td class="ps-4 py-2">
                                <div class="rounded overflow-hidden" style="width: 50px; height: 50px;">
                                    @php
                                        if (str_starts_with($product->image ?? '', 'http')) {
                                            $pImg = $product->image;
                                        } elseif ($product->image) {
                                            $pImg = str_starts_with($product->image, 'images/') ? asset($product->image) : asset('storage/' . $product->image);
                                        } else {
                                            $pImg = 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=200';
                                        }
                                    @endphp
                                    <img src="{{ $pImg }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $product->name }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800';">
                                </div>
                            </td>
                            <td class="py-2">
                                <span class="fw-bold text-primary d-block">{{ $product->name }}</span>
                                <span class="text-muted" style="font-size: 0.75rem;">{{ Str::limit($product->description, 35) }}</span>
                            </td>
                            <td class="py-2">
                                <span class="text-muted small">{{ $product->category->name ?? 'Tanpa Kategori' }}</span>
                            </td>
                            <td class="py-2">
                                <span class="fw-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-2">
                                @if($product->stock <= 0)
                                    <span class="badge py-1.5 px-3 rounded-pill" style="background-color: #FCE4D6; color: #C65911;">Habis (0)</span>
                                @elseif($product->stock <= 5)
                                    <span class="badge py-1.5 px-3 rounded-pill" style="background-color: #FFF2CC; color: #7F6000;">Menipis ({{ $product->stock }})</span>
                                @else
                                    <span class="badge py-1.5 px-3 rounded-pill" style="background-color: #E2F0D9; color: #385723;">Tersedia ({{ $product->stock }})</span>
                                @endif
                            </td>
                            <td class="text-end pe-4 py-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-link text-muted p-1 border-0 me-1">
                                    <i class="fa-regular fa-pen-to-square fs-6"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-1 border-0">
                                        <i class="fa-regular fa-trash-can fs-6"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Custom Bakery Pagination (Figma Screenshot 4) -->
        <div class="p-3 bg-white d-flex justify-content-center border-top border-light">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
