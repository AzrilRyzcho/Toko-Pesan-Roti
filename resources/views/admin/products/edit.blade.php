@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card card-figma border-0 p-4 p-md-5 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-light pb-3">
                    <h3 class="font-serif fw-bold text-primary mb-0">Edit Produk</h3>
                    <a href="{{ route('admin.products.index') }}" class="text-muted small text-decoration-none"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
                </div>

                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-semibold text-primary">Kategori Produk</label>
                        <select id="category_id" name="category_id" class="form-select form-control-figma @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-primary">Nama Produk</label>
                        <input type="text" id="name" name="name" class="form-control form-control-figma @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold text-primary">Deskripsi Produk</label>
                        <textarea id="description" name="description" class="form-control form-control-figma @error('description') is-invalid @enderror" rows="4">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price & Stock -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-semibold text-primary">Harga (Rp)</label>
                            <input type="number" id="price" name="price" class="form-control form-control-figma @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" min="0" step="1000" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="stock" class="form-label fw-semibold text-primary">Jumlah Stok</label>
                            <input type="number" id="stock" name="stock" class="form-control form-control-figma @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" min="0" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Current Image Preview & Upload -->
                    <div class="mb-3">
                        <label for="image" class="form-label fw-semibold text-primary d-block">Foto Produk</label>
                        @if($product->image)
                            @php
                                $editImg = str_starts_with($product->image ?? '', 'http') ? $product->image : (str_starts_with($product->image, 'images/') ? asset($product->image) : asset('storage/' . $product->image));
                            @endphp
                            <div class="mb-2">
                                <img src="{{ $editImg }}" class="rounded shadow-sm" alt="{{ $product->name }}" style="max-height: 120px; object-fit: cover;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800';">
                            </div>
                        @endif
                        <input type="file" id="image" name="image" class="form-control form-control-figma @error('image') is-invalid @enderror" accept="image/*">
                        <span class="text-muted small d-block mt-1">Biarkan kosong jika tidak ingin mengunggah foto baru.</span>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Availability Switch -->
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="is_available" name="is_available" value="1" {{ old('is_available', $product->is_available) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold text-primary" for="is_available">Produk Tersedia untuk Dijual</label>
                    </div>

                    <button type="submit" class="btn btn-caramel w-100 py-3">
                        <i class="fa-solid fa-rotate me-1"></i> Perbarui Produk
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
