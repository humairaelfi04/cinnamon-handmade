<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Cinnamon Handmade')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Palet Warna */
        :root {
            --cream-bg: #FAF8F1;
            --white-card: #FFFFFF;
            --dark-text: #3D3B30;
            --primary-brown: #A07855;
            --sidebar-bg: #3D3B30;
            --light-border: #EAE0C8;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            background-color: var(--cream-bg);
            color: var(--dark-text);
        }
        /* Layout Utama */
        .admin-container { display: flex; min-height: 100vh; }
        .sidebar {
            width: 240px;
            background-color: var(--sidebar-bg);
            color: var(--white-card);
            padding: 20px;
            flex-shrink: 0;
        }
        .sidebar h2 { text-align: center; color: var(--cream-bg); margin-bottom: 30px; }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar ul li a {
            color: var(--cream-bg);
            text-decoration: none;
            display: block;
            padding: 12px 18px;
            border-radius: 6px;
            margin-bottom: 5px;
            transition: background-color 0.3s;
        }
        .sidebar ul li a:hover, .sidebar ul li a.active { background-color: var(--primary-brown); }
        .content { flex-grow: 1; padding: 40px; }
        .card {
            background: var(--white-card);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 30px;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--light-border);
            padding-bottom: 20px;
        }
        h1 { margin: 0; font-weight: 700; }
        /* Tombol & Tabel */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid var(--light-border); padding: 12px 15px; text-align: left; vertical-align: middle; }
        th { background-color: var(--cream-bg); font-weight: 500; }
        .btn {
            padding: 10px 15px; border: none; border-radius: 6px; color: white; text-decoration: none; cursor: pointer; font-weight: 500; transition: opacity 0.3s;
        }
        .btn:hover { opacity: 0.85; }
        .btn-primary { background-color: var(--primary-brown); }
        .btn-danger { background-color: #e74c3c; }
        .btn-warning { background-color: #f1c40f; }

        /* === CSS UNTUK FORM === */
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--light-border);
            border-radius: 6px;
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            box-sizing: border-box;
        }
        textarea.form-control { resize: vertical; min-height: 120px; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h2>Cinnamon<br>Handmade</h2>
            <ul>
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">Pesanan</a></li>
                <li><a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">Produk</a></li>
                <li><a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">Ulasan</a></li>
                <li><a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Kategori</a></li>
                <li><a href="{{ route('admin.tags.index') }}" class="{{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">Kelola Tag</a></li>
                <li><a href="{{ route('admin.raw-materials.index') }}" class="{{ request()->routeIs('admin.raw-materials.*') ? 'active' : '' }}">Bahan Baku</a></li>
                <li><a href="{{ route('admin.custom-options.index') }}" class="{{ request()->routeIs('admin.custom-options.*') ? 'active' : '' }}">Opsi Kustom</a></li>

                {{-- Pisahkan Laporan --}}
                <li style="margin-top: 20px; font-size: 0.8rem; color: #95a5a6; padding: 0 18px;">LAPORAN</li>
                <li><a href="{{ route('admin.reports.sales') }}" class="{{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">Penjualan</a></li>
                <li><a href="{{ route('admin.reports.raw-materials') }}" class="{{ request()->routeIs('admin.reports.raw-materials') ? 'active' : '' }}">Bahan Baku</a></li>
            </ul>
        </aside>

        <main class="content">
            <div class="card">
                @yield('content')
            </div>
        </main>
    </div>
     @stack('scripts')
</body>
</html>
