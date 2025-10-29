@extends('layouts.app')

@section('title', 'Galeri Cerita Cinnamon')

@push('styles')
<style>
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 kolom di desktop */
        gap: 30px;
        margin-top: 40px;
    }
    .gallery-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .gallery-card .photo {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }
    .gallery-card .content {
        padding: 20px;
    }
    .gallery-card .comment {
        font-style: italic;
        color: #555;
        border-left: 3px solid var(--primary-brown);
        padding-left: 15px;
        margin-bottom: 15px;
        min-height: 50px; /* Menjaga tinggi komentar agar konsisten */
    }
    .gallery-card .author {
        font-weight: 700;
        color: var(--dark-text);
    }
    .gallery-card .rating {
        color: #f5b301;
        margin-bottom: 10px;
    }
    .pagination-container {
        margin-top: 50px;
        display: flex;
        justify-content: center;
    }
    /* Responsif untuk tablet dan mobile */
    @media (max-width: 992px) {
        .gallery-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .gallery-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="hero-text">
        <h1>Galeri Cerita</h1>
        <p>Lihat bagaimana karya kami menjadi bagian dari kisah pelanggan setia Cinnamon Handmade.</p>
    </div>

    @if($reviews->isNotEmpty())
        <div class="gallery-grid">
            @foreach ($reviews as $review)
                <div class="gallery-card">
                    @if($review->photo)
                        <img src="{{ asset('storage/' . $review->photo) }}" alt="Foto ulasan dari {{ $review->user->name }}" class="photo">
                    @else
                        {{-- Placeholder jika tidak ada foto --}}
                        <img src="https://placehold.co/400x300/EAE0C8/3D3B30?text=Karya+Custom" alt="Placeholder" class="photo">
                    @endif
                    <div class="content">
                        <div class="rating">
                            @for ($i = 1; $i <= 5; $i++)
                                {!! $i <= $review->rating ? '★' : '☆' !!}
                            @endfor
                        </div>
                        @if($review->comment)
                            <p class="comment">"{{ Str::limit($review->comment, 100) }}"</p> {{-- Batasi panjang komentar agar rapi --}}
                        @endif
                        <p class="author">- {{ $review->user->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Menampilkan link paginasi --}}
        <div class="pagination-container">
            {{ $reviews->links() }}
        </div>
    @else
        <p style="text-align: center; margin-top: 50px; padding: 40px; background-color: #fff; border-radius: 12px;">Belum ada cerita yang dibagikan. Jadilah yang pertama memberikan ulasan untuk produk custom Anda!</p>
    @endif
</div>
@endsection

