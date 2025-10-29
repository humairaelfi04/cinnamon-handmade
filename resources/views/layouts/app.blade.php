<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cinnamon Handmade')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream-bg: #FAF8F1;
            --white-card: #FFFFFF;
            --dark-text: #3D3B30;
            --primary-brown: #A07855;
            --light-border: #EAE0C8;
            --hover-brown: #8a6646;
        }
        body { font-family: 'Montserrat', sans-serif; margin: 0; background-color: var(--cream-bg); color: var(--dark-text); }
        .container { max-width: 1200px; margin: 40px auto; padding: 20px; }

        /* Navbar */
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 15px 40px; background-color: var(--white-card); box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 70px; }
        .navbar .brand a { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 700; text-decoration: none; color: var(--dark-text); }
        .navbar .nav-links { display: flex; align-items: center; gap: 20px; }
        .navbar .nav-links a { text-decoration: none; color: var(--dark-text); font-weight: 500; padding: 8px 12px; border-radius: 6px; transition: all 0.3s ease; }
        .navbar .nav-links a:hover { background-color: var(--cream-bg); color: var(--primary-brown); }

        /* Dropdown Profil */
        .cart-count { background-color: var(--primary-brown); color: white; border-radius: 50%; padding: 2px 7px; font-size: 0.8rem; vertical-align: top; margin-left: -5px; }
        .profile-dropdown { position: relative; display: inline-block; padding-bottom: 15px; margin-bottom: -15px; }
        .profile-button { background-color: transparent; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 500; padding: 8px 12px; }
        .profile-button img { width: 32px; height: 32px; border-radius: 50%; }
        .dropdown-content { display: none; position: absolute; right: 0; background-color: var(--white-card); min-width: 220px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1); z-index: 1; border-radius: 8px; overflow: hidden; margin-top: 10px; }
        .profile-dropdown:hover .dropdown-content { display: block; }
        .dropdown-header { padding: 15px; border-bottom: 1px solid var(--light-border); }
        .dropdown-header small { display: block; color: #6c757d; }
        .dropdown-content a, .dropdown-content .logout-button { color: var(--dark-text); padding: 12px 16px; text-decoration: none; display: block; width: 100%; text-align: left; background: none; border: none; font-family: 'Montserrat', sans-serif; font-size: 0.95rem; cursor: pointer; }
        .dropdown-content a:hover, .dropdown-content .logout-button:hover { background-color: var(--cream-bg); }

        /* === CSS YANG HILANG (SUDAH DITAMBAHKAN KEMBALI) === */
        /* Teks & Gambar Utama di Homepage */
        .hero-text h1 { font-family: 'Playfair Display', serif; font-size: 3rem; text-align: center; }
        .hero-text p { text-align: center; font-size: 1.1rem; color: #6c757d; }
        .hero-image { width: 100%; max-height: 400px; object-fit: cover; border-radius: 12px; margin-bottom: 40px; }

        /* Konten Produk */
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 30px; margin-top: 40px; }
        .product-card { background-color: var(--white-card); border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .product-card img { max-width: 100%; height: 250px; object-fit: cover; }
        .product-card .info { padding: 20px; }
        .product-card h3 { margin: 0 0 10px 0; font-size: 1.2rem; }
        .product-card p { font-size: 1.1rem; font-weight: 700; color: var(--primary-brown); margin: 0 0 15px 0; }

        /* Tombol & Form Umum */
        .btn, .btn-detail { display: inline-block; background-color: var(--primary-brown); color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; border: none; cursor: pointer; transition: background-color 0.3s; }
        .btn:hover, .btn-detail:hover { background-color: var(--hover-brown); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
        .form-control { width: 100%; padding: 12px 15px; border: 1px solid var(--light-border); border-radius: 6px; font-family: 'Montserrat', sans-serif; font-size: 1rem; box-sizing: border-box; }
        textarea.form-control { resize: vertical; min-height: 100px; }

        /* Paginasi */
        .pagination-wrapper { margin-top: 30px; display: flex; justify-content: center; }
        .pagination { display: flex; padding-left: 0; list-style: none; border-radius: .25rem; }
        .page-item .page-link { position: relative; display: block; padding: .5rem .9rem; margin-left: -1px; line-height: 1.25; color: var(--primary-brown); background-color: #fff; border: 1px solid var(--light-border); text-decoration: none; transition: all 0.2s; }
        .page-item:first-child .page-link { border-top-left-radius: .25rem; border-bottom-left-radius: .25rem; }
        .page-item:last-child .page-link { border-top-right-radius: .25rem; border-bottom-right-radius: .25rem; }
        .page-item.active .page-link { z-index: 1; color: #fff; background-color: var(--primary-brown); border-color: var(--primary-brown); }
        .page-item.disabled .page-link { color: #6c757d; pointer-events: none; background-color: #fff; border-color: #dee2e6; }
        .page-item .page-link:hover { background-color: var(--cream-bg); }
    </style>
    @stack('styles')
</head>
<body>
    @include('layouts.partials.navbar')
    <main>
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
