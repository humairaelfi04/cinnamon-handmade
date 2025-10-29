<nav class="navbar">
    <div class="brand">
        <a href="{{ route('home') }}">Cinnamon Handmade</a>
    </div>
    <div class="nav-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('products.index') }}">Katalog</a>
        <a href="{{ route('builder.index') }}">Custom Order</a>
        <a href="{{ route('gallery.index') }}">Galeri Cerita</a>
        <a href="{{ route('cart.index') }}">
            Keranjang
            @if(session('cart') || (Auth::check() && Auth::user()->carts()->count() > 0) )
                <span class="cart-count">
                    {{ session('cart') ? count(session('cart')) : Auth::user()->carts()->count() }}
                </span>
            @endif
        </a>

        @guest
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @else
            <div class="profile-dropdown">
                <button class="profile-button">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=A07855&color=fff" alt="Avatar">
                    <span>{{ Auth::user()->name }}</span>
                </button>
                <div class="dropdown-content">
                    <div class="dropdown-header">
                        <strong>{{ Auth::user()->name }}</strong>
                        <small>{{ Auth::user()->email }}</small>
                    </div>
                    <a href="{{ route('orders.index') }}">Pesanan Saya</a>

                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('admin.orders.index') }}">Admin Panel</a>
                    @endif

                    {{-- Tambahkan garis pemisah --}}
                    <div class="dropdown-divider"></div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-button">Keluar</button>
                    </form>
                </div>
            </div>
        @endguest
    </div>
</nav>

{{-- Tambahkan sedikit CSS untuk dropdown divider & hover effect --}}
<style>
    .dropdown-divider {
        height: 1px;
        margin: 0.5rem 0;
        overflow: hidden;
        background-color: #e9ecef;
    }
    .dropdown-content a:hover, .dropdown-content .logout-button:hover {
        background-color: #f1f1f1;
    }
</style>
