@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    {{-- Bagian Detail Produk Utama --}}
    <div class="product-detail-container">
        <div class="product-image-gallery">
            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/600x600/EAE0C8/3D3B30?text=Cinnamon' }}" alt="{{ $product->name }}">
        </div>
        <div class="product-info">
            <h1>{{ $product->name }}</h1>
            <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

            @if($product->stock > 0)
                <span class="stock">Stok Tersedia: {{ $product->stock }}</span>
            @else
                <span class="stock stock-out">Stok Habis</span>
            @endif

            <p class="description">{{ $product->description }}</p>

            <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" @if($product->stock == 0) disabled @endif>
                <button type="submit" class="btn-add-cart" @if($product->stock == 0) disabled @endif>
                    Masukkan ke Keranjang
                </button>
            </form>
        </div>
    </div>

    {{-- ================================================================= --}}
    {{-- AWAL DARI BAGIAN ISI PAKET BUNDLE (LENGKAP DENGAN HARGA) --}}
    {{-- ================================================================= --}}
    @if($product->type === 'bundle' && $product->bundledProducts->isNotEmpty())
    <div class="bundle-section">
        <hr class="separator">
        <h3>Isi Paket Hemat Ini:</h3>
        <div class="bundle-items-grid">
            @foreach($product->bundledProducts as $item)
            <a href="{{ route('products.show', $item->slug ?? $item->id) }}" class="bundle-item-card" title="Lihat detail {{ $item->name }}">
                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://placehold.co/150x150/EAE0C8/3D3B30?text=Cinnamon' }}" alt="{{ $item->name }}">
                <p>{{ $item->name }}</p>
            </a>
            @endforeach
        </div>

        <div class="bundle-pricing-summary">
            <div class="price-item">
                <span>Total Harga Asli</span>
                <s>Rp {{ number_format($product->total_value, 0, ',', '.') }}</s>
            </div>
            <div class="price-item">
                <span>Harga Paket Hemat</span>
                <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
            </div>
            <div class="price-item savings">
                <span>Anda Hemat</span>
                <strong>Rp {{ number_format($product->savings, 0, ',', '.') }}!</strong>
            </div>
        </div>
    </div>
    @endif
    {{-- ================================================================= --}}
    {{-- AKHIR DARI BAGIAN ISI PAKET BUNDLE --}}
    {{-- ================================================================= --}}

    {{-- Bagian Ulasan Pelanggan --}}
    <div class="reviews-section">
        <hr class="separator">
        <h2 style="margin-bottom: 30px;">Ulasan Pelanggan ({{ $product->reviews->count() }})</h2>

        @forelse ($product->reviews->sortByDesc('created_at') as $review)
            <div class="review-item">
                <div class="review-avatar">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=EAE0C8&color=3D3B30" alt="{{ $review->user->name }}">
                </div>
                <div class="review-content">
                    <div class="review-header">
                        <div>
                            <strong>{{ $review->user->name }}</strong>
                            <div class="star-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    {!! $i <= $review->rating ? '★' : '☆' !!}
                                @endfor
                            </div>
                        </div>
                        <small class="review-date">{{ $review->created_at->format('d M Y') }}</small>
                    </div>
                    @if ($review->comment)
                        <p class="review-comment">{{ $review->comment }}</p>
                    @endif
                    @if ($review->photo)
                        <a href="{{ asset('storage/' . $review->photo) }}" target="_blank" class="review-photo-link">
                            <img src="{{ asset('storage/' . $review->photo) }}" alt="Foto Ulasan dari {{ $review->user->name }}" class="review-photo">
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <p style="text-align: center; color: #999; margin-top: 40px;">Jadilah yang pertama memberikan ulasan untuk produk ini!</p>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
/* Style Variabel (asumsikan ada di layout utama Anda) */
:root {
    --primary-brown: #8D6E63; /* Contoh */
    --light-border: #E0E0E0; /* Contoh */
}

/* Style Detail Produk */
.container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
.product-detail-container { display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: start; }
.product-image-gallery img { width: 100%; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.product-info h1 { font-family: 'Playfair Display', serif; font-size: 2.5rem; margin-top: 0; margin-bottom: 15px; }
.product-info .price { font-size: 2rem; font-weight: 700; color: var(--primary-brown); margin-bottom: 20px; }
.product-info .stock { font-size: 0.9rem; background-color: #e6f3ef; color: #6a9c89; padding: 5px 10px; border-radius: 20px; display: inline-block; margin-bottom: 20px; }
.product-info .stock-out { background-color: #f8d7da; color: #721c24; }
.product-info .description { line-height: 1.8; margin-bottom: 30px; }
.add-to-cart-form { display: flex; align-items: center; }
.add-to-cart-form input[type="number"] { width: 80px; padding: 10px; text-align: center; border: 1px solid var(--light-border); border-radius: 6px; margin-right: 10px; }
.btn-add-cart { padding: 12px 25px; border: none; border-radius: 6px; background-color: var(--primary-brown); color: white; font-weight: 500; font-family: 'Montserrat', sans-serif; cursor: pointer; transition: opacity 0.3s; }
.btn-add-cart:hover { opacity: 0.85; }
.btn-add-cart:disabled { background-color: #ccc; cursor: not-allowed; }

/* Style baru untuk bagian ulasan dan bundle */
.separator { border: none; border-top: 1px solid var(--light-border); margin: 60px 0 40px 0; }
.bundle-section h3, .reviews-section h2 { font-family: 'Playfair Display', serif; font-size: 1.8rem; margin-bottom: 20px; }
.bundle-items-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 20px; }
.bundle-item-card { text-align: center; text-decoration: none; color: inherit; }
.bundle-item-card img { width: 100%; height: 120px; object-fit: cover; border-radius: 8px; border: 1px solid var(--light-border); transition: transform 0.2s ease-in-out; }
.bundle-item-card:hover img { transform: scale(1.05); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
.bundle-item-card p { font-size: 0.9rem; font-weight: 500; margin-top: 10px; }

/* Style untuk Ringkasan Harga Bundle */
.bundle-pricing-summary {
    margin-top: 40px;
    padding: 20px;
    border: 2px dashed #D3C4B3;
    border-radius: 8px;
    max-width: 450px;
    background-color: #fdfaf6;
}
.bundle-pricing-summary .price-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 1.1rem;
    padding: 12px 0;
}
.bundle-pricing-summary .price-item:not(:last-child) {
    border-bottom: 1px solid var(--light-border);
}
.bundle-pricing-summary .price-item s {
    color: #999;
}
.bundle-pricing-summary .price-item strong {
    font-weight: 700;
}
.bundle-pricing-summary .price-item.savings {
    font-size: 1.2rem;
    color: #c0392b; /* Warna merah untuk menyorot penghematan */
}
.bundle-pricing-summary .price-item.savings strong {
    font-family: 'Playfair Display', serif;
}


/* Style Ulasan */
.review-item { display: grid; grid-template-columns: 60px 1fr; gap: 20px; margin-bottom: 30px; border-bottom: 1px solid #f0f0f0; padding-bottom: 30px; }
.review-item:last-child { border-bottom: none; }
.review-avatar img { width: 60px; height: 60px; border-radius: 50%; }
.review-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
.star-rating { color: #f5b301; font-size: 1.1rem; margin-top: 5px; }
.review-comment { margin: 10px 0; line-height: 1.7; }
.review-date { font-size: 0.8rem; color: #6c757d; }
.review-photo-link { display: inline-block; margin-top: 10px; }
.review-photo { max-width: 150px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: transform 0.2s; }
.review-photo:hover { transform: scale(1.05); }
</style>
@endpush
