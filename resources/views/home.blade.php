@extends('layouts.app')

@section('title', 'Selamat Datang di Cinnamon Handmade')

@section('content')
<div class="container">
    {{-- Bagian Hero --}}
    <div class="hero-text">
        <h1>Selamat Datang di Cinnamon Handmade</h1>
        <p>Temukan produk kerajinan tangan terbaik di sini!</p>
    </div>
</div>

{{-- ================================================================= --}}
{{-- BAGIAN CERITA BRAND (VERSI BARU DARI BUKU) --}}
{{-- ================================================================= --}}
<section class="about-us-section">
    <div class="container about-us-grid">
        <div class="about-us-image-wrapper">
            {{-- GANTI URL INI dengan foto yang merepresentasikan brand-mu --}}
            <img src="https://placehold.co/600x700/D4BBA0/3D3B30?text=Our+Story" alt="Cerita Brand Cinnamon Handmade">
        </div>
        <div class="about-us-content">
            <h2 class="section-subtitle">Tentang Kami</h2>
            <h1 class="section-title">Inspired by Wild Life</h1>

            <div class="brand-philosophy">
                <h4>Sebuah Pemberian dari Alam</h4>
                <p>Permata, batuan, cangkang, dan fosil adalah sebuah bentuk pemberian dari alam yang patut untuk disyukuri. Keindahannya dapat dinikmati dengan berbagai cara, mulai dari dekorasi ruangan hingga diubah menjadi sebuah perhiasan dengan nilai estetika yang tinggi.</p>

                <h4>Awal Mula Cinnamon Handmade</h4>
                <p>Kami berdiri sejak akhir tahun 2018 melalui akun Instagram, dan bertumbuh hingga pada Agustus 2021 kami mendirikan toko fisik pertama kami. Dengan slogan "Inspired by Wild Life", hampir semua produk yang kami hasilkan terinspirasi dari alam, sehingga menggambarkan keindahan alam itu sendiri.</p>

                <h4>Fokus Kami</h4>
                <p>Cinnamon Handmade berfokus membuat kerajinan tangan dalam bentuk perhiasan seperti gelang, cincin, dan kalung, khususnya yang terbuat dari batu alam. Selain itu, kami juga membuat terrarium dan pajangan batu alam untuk melengkapi desain ruangan Anda agar terlihat lebih segar dan menawan.</p>
            </div>

            <a href="{{ route('products.index') }}" class="btn btn-outline">Jelajahi Karya Kami</a>
        </div>
    </div>
</section>
{{-- ================================================================= --}}
{{-- AKHIR DARI BAGIAN CERITA BRAND --}}
{{-- ================================================================= --}}

<div class="container" style="margin-top: 40px;">
    {{-- Bagian Daftar Produk --}}
    <div class="products-grid">
        @forelse ($products as $product)
            <div class="product-card">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}">
                <div class="info">
                    <h3>{{ $product->name }}</h3>
                    <p>Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <a href="{{ route('products.show', $product->id) }}" class="btn-detail">Lihat Detail</a>
                </div>
            </div>
        @empty
            <p style="text-align: center; grid-column: 1 / -1;">Belum ada produk yang tersedia saat ini.</p>
        @endforelse
    </div>
</div>

{{-- ================================================================= --}}
{{-- AWAL DARI BAGIAN FAQ & CARE GUIDE --}}
{{-- ================================================================= --}}
<section class="faq-section">
    <div class="container">
        <div class="hero-text" style="margin-bottom: 40px;">
            <h1>Perlu Bantuan?</h1>
            <p>Beberapa pertanyaan umum dan panduan perawatan untuk menjaga karyamu tetap indah.</p>
        </div>

        <div class="faq-container">
            {{-- Pertanyaan 1 --}}
            <details class="faq-item">
                <summary class="faq-question">
                    Bagaimana cara merawat perhiasan batu alam saya?
                </summary>
                <div class="faq-answer">
                    <p>Perhiasan handmade, terutama dengan batu alam, membutuhkan sedikit perhatian ekstra. Hindari kontak langsung dengan bahan kimia keras seperti parfum, lotion, atau pembersih. Lepaskan sebelum mandi atau berenang. Untuk membersihkan, cukup usap lembut dengan kain kering yang halus.</p>
                </div>
            </details>

            {{-- Pertanyaan 2 --}}
            <details class="faq-item">
                <summary class="faq-question">
                    Apakah produk ini tahan air?
                </summary>
                <div class="faq-answer">
                    <p>Meskipun batu alamnya sendiri tahan air, kami sangat menyarankan untuk tidak mengenakannya saat mandi atau berenang. Air dan sabun dapat melemahkan benang atau tali kerangka seiring waktu dan mengurangi kilau alami dari beberapa jenis batu.</p>
                </div>
            </details>

            {{-- Pertanyaan 3 --}}
            <details class="faq-item">
                <summary class="faq-question">
                    Berapa lama proses pembuatan pesanan custom?
                </summary>
                <div class="faq-answer">
                    <p>Setiap pesanan custom dirakit dengan tangan dan hati-hati. Biasanya, proses pembuatan memakan waktu sekitar 2-4 hari kerja, tergantung pada kerumitan desain dan antrian pesanan. Kami akan selalu memberikan estimasi terbaik saat kamu memesan.</p>
                </div>
            </details>

            {{-- Pertanyaan 4 --}}
            <details class="faq-item">
                <summary class="faq-question">
                    Apakah warna batu bisa sama persis dengan di foto?
                </summary>
                <div class="faq-answer">
                    <p>Karena kami menggunakan batu alam asli, setiap batu adalah unik dan memiliki corak serta gradasi warna yang sedikit berbeda satu sama lain. Inilah yang membuat setiap karya Cinnamon Handmade begitu istimewa dan personal. Kami selalu berusaha memilih batu yang paling mendekati foto produk.</p>
                </div>
            </details>
        </div>
    </div>
</section>
{{-- ================================================================= --}}
{{-- AKHIR DARI BAGIAN FAQ & CARE GUIDE --}}
{{-- ================================================================= --}}


{{-- ================================================================= --}}
{{-- AWAL DARI TOMBOL WHATSAPP MENGAMBANG --}}
{{-- ================================================================= --}}
{{-- GANTI NOMOR 6281234567890 DENGAN NOMOR WHATSAPP-MU --}}
<a href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20dengan%20produk%20Cinnamon%20Handmade." class="whatsapp-float" target="_blank" title="Chat dengan Kami di WhatsApp">
    {{-- PERUBAHAN: Menggunakan SVG Ikon WhatsApp yang Asli --}}
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 28px; height: 28px; fill: white;">
        <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.8 0-67.6-9.2-97.2-25.7l-6.7-4-71.6 18.7 19-70.1-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-.5-1.1-3.2-1.8-6.6-3.2-3.4-1.4-20.2-9.9-23.3-11s-5.4-1.6-7.7 1.6c-2.3 3.2-8.8 11-10.8 13.2-2 2.2-4 2.5-7.4  .8-3.4-1.7-14.4-5.3-27.4-17c-10.1-9.1-16.9-20.4-18.9-23.8-2-3.4-.2-5.2.2-6.9.4-.5.9-1.3 1.3-1.8 1.8-2.2 2.3-3.6 3.4-6 1.1-2.4.6-4.5 0-5.9s-7.7-18.5-10.5-25.4c-2.8-6.9-5.6-5.9-7.7-5.9-2.1-.1-4.5-.1-6.9-.1-2.4-.1-6.3.8-9.6 3.9-3.2 3.2-12.2 12-12.2 29.2 0 17.2 12.5 33.9 14.2 36.1 1.7 2.2 24.5 37.5 59.5 52.5 35 15 35 10 41.3 9.4 6.3-.6 20.2-8.2 23-16.1 2.8-7.8 2.8-14.5 2-15.9z"/>
    </svg>
</a>
{{-- ================================================================= --}}
{{-- AKHIR DARI TOMBOL WHATSAPP MENGAMBANG --}}
{{-- ================================================================= --}}

@endsection

@push('styles')
<style>
    /* Styling untuk Grid Produk yang sudah kamu punya */
    .hero-text {
        text-align: center;
        padding: 40px 0;
    }
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
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
    .product-card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }
    .product-card .info {
        padding: 20px;
        text-align: center;
    }
    .product-card .info h3 {
        margin: 0 0 10px 0;
        font-size: 1.1rem;
    }
    .product-card .info p {
        margin: 0 0 15px 0;
        font-weight: 700;
        color: var(--primary-brown);
    }

    /* Styling untuk bagian About Us */
    .about-us-section {
        padding: 80px 0;
        background-color: var(--white-card);
    }

    .about-us-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 60px;
        align-items: center;
    }

    .about-us-image-wrapper img {
        width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        display: block;
    }

    .about-us-content .section-subtitle {
        color: var(--primary-brown);
        font-weight: 500;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .about-us-content .section-title {
        font-size: 2.5rem;
        margin-top: 0;
        margin-bottom: 20px;
        color: var(--dark-text);
    }

    /* Style baru untuk Visi, Misi, Filosofi */
    .brand-philosophy h4 {
        font-size: 1.1rem;
        color: var(--dark-text);
        margin-bottom: 5px;
        margin-top: 20px;
    }
    .brand-philosophy p {
        line-height: 1.7;
        margin-bottom: 15px;
        font-size: 0.95rem;
        color: #555;
    }


    .btn-outline {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 28px;
        border: 2px solid var(--primary-brown);
        color: var(--primary-brown);
        background-color: transparent;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-outline:hover {
        background-color: var(--primary-brown);
        color: var(--white-card);
    }

    /* Penyesuaian untuk layar kecil (Mobile) */
    @media (max-width: 768px) {
        .about-us-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .about-us-content {
            text-align: center;
        }
    }

    /* Styling untuk bagian FAQ */
    .faq-section {
        padding: 80px 0;
        background-color: var(--cream-bg);
    }
    .faq-container {
        max-width: 800px;
        margin: 0 auto;
    }
    .faq-item {
        background-color: var(--white-card);
        border-radius: 8px;
        margin-bottom: 15px;
        border: 1px solid var(--light-border);
    }
    .faq-question {
        padding: 20px;
        font-weight: 700;
        cursor: pointer;
        list-style: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .faq-question::-webkit-details-marker {
        display: none;
    }
    .faq-question::after {
        content: '+';
        font-size: 1.5rem;
        color: var(--primary-brown);
        transition: transform 0.3s ease;
    }
    .faq-item[open] .faq-question::after {
        content: '−';
        transform: rotate(180deg);
    }
    .faq-answer {
        padding: 0 20px 20px 20px;
        line-height: 1.7;
        border-top: 1px solid var(--light-border);
    }

    /* =============================================== */
    /* STYLE UNTUK TOMBOL WHATSAPP */
    /* =============================================== */
    .whatsapp-float {
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 40px;
        right: 40px;
        background-color: #25d366;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        box-shadow: 2px 2px 8px rgba(0,0,0,0.2);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
    }
    .whatsapp-float:hover {
        transform: scale(1.1);
    }
    /* =============================================== */
</style>
@endpush

