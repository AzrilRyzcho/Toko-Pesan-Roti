@extends('layouts.admin')

@section('title', '')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Row (Figma Screenshot 3) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="font-serif fw-bold text-primary mb-1">Kelola Kategori</h3>
            <p class="text-muted small mb-0">Atur pengelompokan produk toko roti Anda.</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Search input -->
            <div class="input-group" style="width: 240px;">
                <span class="input-group-text bg-white border-secondary-subtle text-muted">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" class="form-control bg-white border-secondary-subtle small" placeholder="Cari kategori...">
            </div>

            <!-- Button + Tambah Kategori -->
            <button class="btn btn-caramel px-3 py-2 rounded-3 text-nowrap" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                <i class="fa-solid fa-plus me-1"></i> Tambah Kategori
            </button>
        </div>
    </div>

    <!-- Table Card (Figma Screenshot 3) -->
    <div class="card card-figma border-0 shadow-sm p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="bg-bakery-cream text-uppercase text-muted" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                    <tr>
                        <th class="ps-4 py-3">NAMA KATEGORI</th>
                        <th class="text-center py-3">JUMLAH PRODUK</th>
                        <th class="text-end pe-4 py-3">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-top-0">
                    @forelse($categories as $category)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle p-2 bg-bakery-cream text-caramel d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                        <i class="fa-solid fa-cookie-bite"></i>
                                    </div>
                                    <span class="fw-bold text-primary">{{ $category->name }}</span>
                                </div>
                            </td>
                            <td class="text-center py-3">
                                <span class="badge py-1.5 px-3 rounded-pill" style="background-color: #FAF6ED; color: #593E22; border: 1px solid #EADBCE;">
                                    {{ $category->products_count ?? $category->products->count() }} Produk
                                </span>
                            </td>
                            <td class="text-end pe-4 py-3">
                                <button class="btn btn-link text-muted p-1 border-0 me-1" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                                    <i class="fa-regular fa-pen-to-square fs-6"></i>
                                </button>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-1 border-0">
                                        <i class="fa-regular fa-trash-can fs-6"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content card-figma p-4 border-0">
                                    <h5 class="font-serif fw-bold text-primary mb-3">Edit Kategori</h5>
                                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-primary small">Nama Kategori</label>
                                            <input type="text" name="name" class="form-control form-control-figma" value="{{ $category->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-primary small">Deskripsi</label>
                                            <textarea name="description" class="form-control form-control-figma" rows="2">{{ $category->description }}</textarea>
                                        </div>
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-light btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-caramel btn-sm px-4">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer Pagination -->
        <div class="p-3 bg-white d-flex justify-content-between align-items-center border-top border-light">
            <span class="text-muted small" style="font-size: 0.78rem;">
                Menampilkan 1 hingga {{ $categories->count() }} dari {{ $categories->count() }} kategori
            </span>
            <div class="d-flex gap-1">
                <button class="btn btn-light btn-sm small px-3 text-muted" disabled>Sebelumnya</button>
                <button class="btn btn-light btn-sm small px-3 text-muted" disabled>Selanjutnya</button>
            </div>
        </div>
    </div>
</div>

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-figma p-4 border-0">
            <h5 class="font-serif fw-bold text-primary mb-3">Tambah Kategori Baru</h5>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold text-primary small">Nama Kategori</label>
                    <input type="text" name="name" class="form-control form-control-figma" placeholder="Contoh: Roti Manis" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-primary small">Deskripsi (Opsional)</label>
                    <textarea name="description" class="form-control form-control-figma" rows="2" placeholder="Catatan singkat kategori..."></textarea>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-caramel btn-sm px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
