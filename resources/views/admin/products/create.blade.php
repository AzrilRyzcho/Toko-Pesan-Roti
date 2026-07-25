@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card card-figma border-0 p-4 p-md-5 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-light pb-3">
                    <h3 class="font-serif fw-bold text-primary mb-0">Tambah Produk Baru</h3>
                    <a href="{{ route('admin.products.index') }}" class="text-muted small text-decoration-none"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
                </div>

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-semibold text-primary">Kategori Produk</label>
                        <select id="category_id" name="category_id" class="form-select form-control-figma @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-primary">Nama Produk</label>
                        <input type="text" id="name" name="name" class="form-control form-control-figma @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: Classic Sourdough Loaf" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold text-primary">Deskripsi Produk</label>
                        <textarea id="description" name="description" class="form-control form-control-figma @error('description') is-invalid @enderror" rows="4" placeholder="Jelaskan cita rasa, bahan, dan cara penyajian produk...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price & Stock -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-semibold text-primary">Harga (Rp)</label>
                            <input type="number" id="price" name="price" class="form-control form-control-figma @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="Contoh: 45000" min="0" step="1000" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="stock" class="form-label fw-semibold text-primary">Jumlah Stok</label>
                            <input type="number" id="stock" name="stock" class="form-control form-control-figma @error('stock') is-invalid @enderror" value="{{ old('stock', 10) }}" placeholder="10" min="0" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="image" class="form-label fw-semibold text-primary">Foto Produk</label>
                        <input type="file" id="image" name="image" class="form-control form-control-figma @error('image') is-invalid @enderror" accept="image/*">
                        <span class="text-muted small d-block mt-1">Format: JPG, PNG, WEBP. Maksimal 2MB.</span>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Availability Switch -->
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="is_available" name="is_available" value="1" checked>
                        <label class="form-check-label fw-semibold text-primary" for="is_available">Produk Tersedia untuk Dijual</label>
                    </div>

                    <button type="submit" class="btn btn-caramel w-100 py-3">
                        <i class="fa-solid fa-check me-1"></i> Simpan Produk
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
