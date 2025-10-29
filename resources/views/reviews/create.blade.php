@extends('layouts.app')
@section('title', 'Beri Ulasan untuk ' . $product->name)
@section('content')
<div class="container" style="max-width: 700px;">
    <div class="card" style="background-color: white; padding: 40px; border-radius: 12px;">
        <h1>Beri Ulasan</h1>
        <p>Bagikan ceritamu tentang produk <strong>{{ $product->name }}</strong>!</p>
        <hr>

        {{-- PERUBAHAN: Menambahkan enctype untuk upload file --}}
        <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <div class="form-group">
                <label>Rating Anda</label>
                <div class="rating">
                    <input type="radio" name="rating" id="5-star" value="5" required><label for="5-star">★</label>
                    <input type="radio" name="rating" id="4-star" value="4"><label for="4-star">★</label>
                    <input type="radio" name="rating" id="3-star" value="3"><label for="3-star">★</label>
                    <input type="radio" name="rating" id="2-star" value="2"><label for="2-star">★</label>
                    <input type="radio" name="rating" id="1-star" value="1"><label for="1-star">★</label>
                </div>
            </div>

            <div class="form-group">
                <label for="comment">Cerita Anda (Opsional)</label>
                <textarea name="comment" id="comment" rows="5" class="form-control" placeholder="Momen spesial apa yang kamu lalui bersama aksesoris ini? Ceritakan pada kami...">{{ old('comment') }}</textarea>
            </div>

            {{-- =============================================== --}}
            {{-- BAGIAN BARU: UPLOAD FOTO --}}
            {{-- =============================================== --}}
            <div class="form-group">
                <label for="photo">Unggah Foto (Opsional)</label>
                <input type="file" name="photo" id="photo" class="form-control" accept="image/jpeg,image/png,image/jpg">
                <small style="font-size: 0.8rem; color: #6c757d;">Tunjukkan pada kami bagaimana karya ini melengkapi gayamu!</small>
                <img id="photo-preview" src="" alt="Preview Foto" style="max-width: 150px; margin-top: 15px; border-radius: 8px; display: none;">
            </div>
            {{-- =============================================== --}}

            <button type="submit" class="btn btn-detail">Kirim Ulasan</button>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.rating { display: flex; flex-direction: row-reverse; justify-content: flex-end; }
.rating input { display: none; }
.rating label { font-size: 2.5rem; color: #ddd; cursor: pointer; transition: color 0.2s; }
.rating input:checked ~ label, .rating label:hover, .rating label:hover ~ label { color: #f5b301; }
.form-control { width: 100%; /* Pastikan input file selebar kontainer */ }
</style>
@endpush

@push('scripts')
<script>
// Script sederhana untuk menampilkan preview gambar
document.getElementById('photo').addEventListener('change', function(event) {
    const preview = document.getElementById('photo-preview');
    const file = event.target.files[0];
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
});
</script>
@endpush
