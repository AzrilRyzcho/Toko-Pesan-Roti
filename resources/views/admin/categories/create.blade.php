@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card card-figma border-0 p-4 p-md-5 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-light pb-3">
                    <h3 class="font-serif fw-bold text-primary mb-0">Tambah Kategori Baru</h3>
                    <a href="{{ route('admin.categories.index') }}" class="text-muted small text-decoration-none"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
                </div>

                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-primary">Nama Kategori</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: French Pastries" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold text-primary">Deskripsi Kategori</label>
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Tuliskan penjelasan singkat mengenai jenis roti dalam kategori ini...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-4">
                        <label for="image" class="form-label fw-semibold text-primary">Gambar Sampul Kategori</label>
                        <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        <span class="text-muted small d-block mt-1">Format: JPG, PNG, WEBP. Maksimal 2MB.</span>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-caramel w-100 py-3">
                        <i class="fa-solid fa-check me-1"></i> Simpan Kategori
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
