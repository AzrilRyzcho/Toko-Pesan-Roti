<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Toko Pesan Roti') }} - Admin Panel</title>

    <!-- Vite Assets (Bootstrap 5, FontAwesome, SCSS) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        html {
            overflow-y: scroll;
            scrollbar-gutter: stable;
        }
        .admin-sidebar {
            width: 250px;
            height: 100vh;
            position: sticky;
            top: 0;
            left: 0;
            overflow-y: auto;
            background-color: #FFFDF5;
            border-right: 1px solid #EADBCE;
            z-index: 100;
            flex-shrink: 0;
        }
        .admin-sidebar .nav-link {
            color: #4A3319;
            font-weight: 500;
            padding: 10px 18px;
            border-radius: 10px;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        .admin-sidebar .nav-link:hover, .admin-sidebar .nav-link.active {
            background-color: #F8F2E6;
            color: #4A3319;
            font-weight: 700;
        }
        .admin-main {
            flex-grow: 1;
            background-color: #FAF6ED;
            min-height: 100vh;
            width: calc(100% - 250px);
        }
        .admin-topbar {
            background-color: #FFFDF5;
            border-bottom: 1px solid #EADBCE;
            padding: 14px 28px;
        }
    </style>
</head>
<body class="bg-bakery-cream">
    <div class="d-flex">
        <!-- Figma Admin Sidebar (Screenshot 2) -->
        <aside class="admin-sidebar p-3 d-flex flex-column justify-content-between">
            <div>
                <!-- Brand Header -->
                <div class="d-flex align-items-center gap-2 mb-4 px-2 pt-2">
                    <span class="font-serif fw-bold fs-4 text-primary">Admin Roti</span>
                </div>

                <!-- Navigation Links -->
                <nav class="nav flex-column">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-border-all fs-5 text-caramel"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                        <i class="fa-solid fa-box-archive fs-5 text-caramel"></i> Katalog Produk
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                        <i class="fa-solid fa-shapes fs-5 text-caramel"></i> Kategori
                    </a>
                    <a href="{{ route('admin.stock.index') }}" class="nav-link {{ request()->routeIs('admin.stock*') ? 'active' : '' }}">
                        <i class="fa-solid fa-boxes-stacked fs-5 text-caramel"></i> Stok
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="nav-link justify-content-between {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-clipboard-list fs-5 text-caramel"></i> Kelola Pesanan
                        </div>
                        @php
                            $unverifiedCount = \App\Models\Order::where('payment_status', 'waiting_verification')->count();
                        @endphp
                        @if($unverifiedCount > 0)
                            <span class="badge rounded-circle bg-caramel text-white px-2 py-1" style="font-size: 0.7rem;">{{ $unverifiedCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users fs-5 text-caramel"></i> Pelanggan
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-line fs-5 text-caramel"></i> Laporan Penjualan
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                        <i class="fa-solid fa-gear fs-5 text-caramel"></i> Pengaturan
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Admin Main Content Body -->
        <div class="admin-main d-flex flex-column">
            <!-- Top Navbar (Screenshot 2) -->
            <header class="admin-topbar d-flex justify-content-between align-items-center">
                <h4 class="font-serif fw-bold text-primary mb-0">@yield('title', 'Ringkasan Hari Ini')</h4>

                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="text-end me-1">
                            <span class="d-block fw-bold text-primary small mb-0">{{ auth()->user()->name }}</span>
                            <span class="d-block text-muted" style="font-size: 0.72rem;">Kepala Toko</span>
                        </div>
                        <div class="rounded-circle bg-bakery-cream p-2 text-caramel d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                            <i class="fa-regular fa-user fs-5"></i>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 py-1.5 rounded-3 ms-2">
                            <i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="p-4 flex-grow-1">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- SweetAlert Integration -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                window.showAlert('Berhasil', "{{ session('success') }}", 'success');
            @endif
            @if(session('error'))
                window.showAlert('Gagal', "{{ session('error') }}", 'error');
            @endif
        });
    </script>
</body>
</html>
