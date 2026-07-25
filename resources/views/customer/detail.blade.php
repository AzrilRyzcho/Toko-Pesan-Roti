@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb (Figma Image 1) -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop', ['category' => $product->category->slug ?? '']) }}" class="text-muted text-decoration-none">{{ $product->category->name ?? 'Kategori' }}</a></li>
            <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Main Product Row -->
    <div class="row g-5">
        <!-- Left: Product Main Image & Thumbnails -->
        <div class="col-lg-6">
            <div class="card card-figma border-0 overflow-hidden mb-3">
                @php
                    if (str_starts_with($product->image ?? '', 'http')) {
                        $mainImg = $product->image;
                    } elseif ($product->image) {
                        $mainImg = str_starts_with($product->image, 'images/') ? asset($product->image) : asset('storage/' . $product->image);
                    } else {
                        $mainImg = 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=800';
                    }
                @endphp
                <img id="main-product-img" src="{{ $mainImg }}" class="w-100" alt="{{ $product->name }}" style="height: 440px; object-fit: cover;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800';">
            </div>

            <!-- Thumbnails selector -->
            <div class="d-flex gap-3">
                <div class="card card-figma p-1 cursor-pointer border-caramel" style="width: 80px; height: 80px;">
                    <img src="{{ $mainImg }}" class="w-100 h-100 rounded" style="object-fit: cover;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800';">
                </div>
                <div class="card card-figma p-1 cursor-pointer" style="width: 80px; height: 80px;">
                    <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=300" class="w-100 h-100 rounded" style="object-fit: cover;">
                </div>
                <div class="card card-figma p-1 d-flex align-items-center justify-content-center bg-light text-muted" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-ellipsis"></i>
                </div>
            </div>
        </div>

        <!-- Right: Badges, Title, Price, Description, Nutrition, Allergen, Add to Cart -->
        <div class="col-lg-6">
            <!-- Badges -->
            <div class="d-flex gap-2 mb-2">
                <span class="badge text-white px-3 py-2 text-uppercase fw-semibold" style="background-color: #C89D7C; font-size: 0.7rem;">BEST SELLER</span>
                <span class="badge text-dark px-3 py-2 text-uppercase fw-semibold" style="background-color: #F3EBDD; color: #593E22; font-size: 0.7rem;">VEGAN</span>
            </div>

            <!-- Title & Price -->
            <h1 class="font-serif fw-bold text-primary display-6 mb-2">{{ $product->name }}</h1>
            <h3 class="font-serif fw-bold text-primary mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>

            <!-- Description -->
            <p class="text-muted small mb-4" style="line-height: 1.8;">
                {{ $product->description ?: 'Dipanggang dengan dedikasi menggunakan ragi alami yang telah kami rawat bertahun-tahun. Menghasilkan tekstur luar yang renyah dengan bagian dalam yang kenyal dan berongga. Rasa asam yang seimbang dan aroma khas fermentasi alami menjadikan roti ini teman sempurna untuk sarapan atau pendamping hidangan utama Anda.' }}
            </p>

            <!-- Nutrition Info Box -->
            <div class="card p-3 border-0 bg-bakery-cream mb-3 rounded-3">
                <div class="fw-bold text-primary small mb-2 d-flex align-items-center gap-1">
                    <i class="fa-solid fa-apple-whole text-caramel"></i> Informasi Nutrisi <span class="fw-normal text-muted">(per 100g)</span>
                </div>
                <div class="row text-center text-md-start g-2 small">
                    <div class="col-6 col-md-3"><span class="text-muted d-block" style="font-size: 0.75rem;">Kalori</span><span class="fw-bold text-primary">240 kcal</span></div>
                    <div class="col-6 col-md-3"><span class="text-muted d-block" style="font-size: 0.75rem;">Karbohidrat</span><span class="fw-bold text-primary">50g</span></div>
                    <div class="col-6 col-md-3"><span class="text-muted d-block" style="font-size: 0.75rem;">Protein</span><span class="fw-bold text-primary">9g</span></div>
                    <div class="col-6 col-md-3"><span class="text-muted d-block" style="font-size: 0.75rem;">Lemak</span><span class="fw-bold text-primary">1g</span></div>
                </div>
            </div>

            <!-- Allergen Notice -->
            <div class="small text-muted mb-4 p-2">
                <i class="fa-solid fa-triangle-exclamation text-warning me-1"></i> <strong>Alergen:</strong> Mengandung <strong>Gluten (Gandum)</strong>. Diproduksi di fasilitas yang juga memproses kacang-kacangan dan susu.
            </div>

            <!-- Form Add to Cart -->
            @if($product->is_available && $product->stock > 0)
                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="d-flex gap-3 align-items-center mb-3">
                        <!-- Quantity Selector -->
                        <div class="input-group" style="width: 130px; height: 48px;">
                            <button class="btn btn-outline-secondary border-secondary-subtle" type="button" onclick="changeQty(-1)">-</button>
                            <input type="number" id="quantity" name="quantity" class="form-control text-center bg-white border-secondary-subtle fw-semibold" value="1" min="1" max="{{ $product->stock }}" readonly>
                            <button class="btn btn-outline-secondary border-secondary-subtle" type="button" onclick="changeQty(1)">+</button>
                        </div>

                        <!-- Add Button -->
                        <button type="submit" class="btn btn-caramel flex-grow-1 py-3 h-100 gap-2">
                            <i class="fa-solid fa-bag-shopping me-1"></i> Tambah ke Keranjang
                        </button>
                    </div>

                    <!-- Custom Notes optional area -->
                    <div class="mb-3">
                        <input type="text" name="notes" class="form-control form-control-figma" placeholder="Catatan kustom (contoh: Tolong dipotong rapi...)">
                    </div>

                    <div class="text-muted small" style="font-size: 0.78rem;">
                        <i class="fa-solid fa-circle-check text-success me-1"></i> Stok tersedia. Pengiriman mulai besok pagi.
                    </div>
                </form>
            @else
                <div class="alert alert-warning text-center small" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> Maaf, produk ini saat ini kehabisan stok.
                </div>
            @endif
        </div>
    </div>

    <!-- Related Products "Mungkin Anda Juga Suka" (Figma Image 1) -->
    <div class="mt-5 pt-4 border-top border-light">
        <h3 class="font-serif fw-bold text-primary text-center mb-4">Mungkin Anda Juga Suka</h3>

        <div class="row g-4">
            @forelse($relatedProducts as $rel)
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('shop.show', $rel->slug) }}" class="text-decoration-none">
                        <div class="product-card-figma h-100 p-2 position-relative">
                            <div class="rounded overflow-hidden mb-2" style="height: 180px;">
                                @php
                                    if (str_starts_with($rel->image ?? '', 'http')) {
                                        $relImg = $rel->image;
                                    } elseif ($rel->image) {
                                        $relImg = str_starts_with($rel->image, 'images/') ? asset($rel->image) : asset('storage/' . $rel->image);
                                    } else {
                                        $relImg = 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&q=80&w=400';
                                    }
                                @endphp
                                <img src="{{ $relImg }}" class="w-100 h-100" style="object-fit: cover;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&q=80&w=800';">
                            </div>
                            <div class="p-2">
                                <h6 class="font-serif fw-bold text-primary mb-1 small">{{ $rel->name }}</h6>
                                <span class="fw-semibold text-muted small">Rp {{ number_format($rel->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center text-muted small py-3">Tidak ada rekomendasi tambahan.</div>
            @endforelse
        </div>
    </div>
</div>

<script>
function changeQty(amount) {
    var input = document.getElementById('quantity');
    var val = parseInt(input.value) + amount;
    var min = parseInt(input.getAttribute('min'));
    var max = parseInt(input.getAttribute('max'));
    if(val >= min && val <= max) {
        input.value = val;
    }
}
</script>
@endsection
