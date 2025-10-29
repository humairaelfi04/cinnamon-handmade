@extends('layouts.app')

@section('title', 'Katalog Produk')

@push('styles')
<style>
    .catalog-container {
        display: grid;
        grid-template-columns: 280px 1fr; /* Kolom untuk filter dan produk */
        gap: 40px;
        align-items: start;
    }
    .filter-sidebar {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        position: sticky;
        top: 20px;
    }
    .filter-group {
        margin-bottom: 25px;
        border-bottom: 1px solid var(--light-border);
        padding-bottom: 25px;
    }
    .filter-group:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .filter-group h4 {
        margin-top: 0;
        margin-bottom: 15px;
        color: var(--primary-brown);
    }
    .filter-option {
        display: block;
        margin-bottom: 10px;
    }
    .filter-buttons {
        margin-top: 20px;
    }
    .btn-filter {
        width: 100%;
        padding: 10px;
        font-weight: 700;
    }
    .btn-reset {
        display: block;
        width: 100%;
        text-align: center;
        margin-top: 10px;
        font-size: 0.9rem;
        color: #6c757d;
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 produk per baris */
        gap: 30px;
    }
    /* Mengambil style product-card dari halaman home */
    .product-card {
        background-color: var(--white-card);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .product-card img { width: 100%; height: 250px; object-fit: cover; }
    .product-card .info { padding: 20px; text-align: center; }
    .product-card .info h3 { margin: 0 0 10px 0; font-size: 1.1rem; }
    .product-card .info p { margin: 0 0 15px 0; font-weight: 700; color: var(--primary-brown); }
    .btn-detail { padding: 10px 20px; }

    /* Responsif */
    @media (max-width: 992px) {
        .catalog-container { grid-template-columns: 1fr; }
        .filter-sidebar { position: static; margin-bottom: 40px; }
        .product-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .product-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="hero-text">
        <h1>Katalog Produk</h1>
        <p>Temukan karya seni yang paling sesuai dengan ceritamu.</p>
    </div>

    <hr style="border: none; border-top: 1px solid var(--light-border); margin: 20px 0 40px 0;">

    <div class="catalog-container">
        {{-- KOLOM KIRI: SIDEBAR FILTER --}}
        <aside class="filter-sidebar">
            <form action="{{ route('products.index') }}" method="GET">
                @foreach ($tags as $type => $groupedTags)
                    <div class="filter-group">
                        <h4>{{ $type }}</h4>
                        @foreach ($groupedTags as $tag)
                            <label class="filter-option">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    {{-- Cek apakah tag ini sedang dipilih --}}
                                    @if(in_array($tag->id, request('tags', []))) checked @endif
                                >
                                {{ $tag->name }}
                            </label>
                        @endforeach
                    </div>
                @endforeach
                <div class="filter-buttons">
                    <button type="submit" class="btn btn-detail btn-filter">Terapkan Filter</button>
                    <a href="{{ route('products.index') }}" class="btn-reset">Reset Filter</a>
                </div>
            </form>
        </aside>

        {{-- KOLOM KANAN: DAFTAR PRODUK --}}
        <main class="product-content">
            @if($products->isNotEmpty())
                <div class="product-grid">
                    @foreach ($products as $product)
                        <div class="product-card">
                            <a href="{{ route('products.show', $product->id) }}">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/300x250/EAE0C8/3D3B30?text=Cinnamon' }}" alt="{{ $product->name }}">
                            </a>
                            <div class="info">
                                <h3>{{ $product->name }}</h3>
                                <p>Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <a href="{{ route('products.show', $product->id) }}" class="btn-detail">Lihat Detail</a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pagination-container" style="margin-top: 40px;">
                    {{ $products->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 50px; background-color: #fff; border-radius: 12px;">
                    <h4>Oops! Tidak Ada Produk yang Sesuai</h4>
                    <p>Coba hapus beberapa filter untuk melihat lebih banyak pilihan.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-detail" style="margin-top: 20px;">Lihat Semua Produk</a>
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
