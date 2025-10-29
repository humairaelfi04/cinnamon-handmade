@extends('layouts.app')

@section('title', 'Checkout')

@push('styles')
<style>
    /* Style untuk halaman checkout */
    .alert { padding: 15px; margin-bottom: 20px; border-radius: 6px; border: 1px solid transparent; }
    .alert-danger { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }
    .alert-danger ul { margin: 0; padding-left: 20px; }
    .checkout-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
        align-items: start;
    }
    .order-summary {
        background-color: var(--white-card);
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        position: sticky;
        top: 20px;
    }
    .order-summary h3 {
        margin-top: 0;
        border-bottom: 1px solid var(--light-border);
        padding-bottom: 10px;
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 0.9rem;
    }
    .summary-total {
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid var(--light-border);
        font-size: 1.2rem;
        font-weight: 700;
    }
    .payment-options .card {
        padding: 20px;
        border: 2px solid var(--light-border);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 10px;
    }
    .payment-options .card:hover {
        border-color: var(--primary-brown);
        background-color: #fffbf5;
    }
    .payment-options input[type="radio"] {
        display: none;
    }
    .payment-options input[type="radio"]:checked + .card {
        border-color: var(--primary-brown);
        background-color: #fcf4e8;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')
<div class="container">
    <h1>Checkout</h1>
    <p>Silakan lengkapi detail pengiriman dan pilih metode pembayaran Anda.</p>
    <hr style="border: none; border-top: 1px solid var(--light-border); margin: 20px 0 40px 0;">

    {{-- Tampilkan pesan error jika ada --}}
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops! Ada beberapa masalah:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="checkout-grid">
            {{-- Kolom Kiri: Form Pengiriman & Pembayaran --}}
            <div class="shipping-form">
                <h3>1. Alamat Pengiriman</h3>
                <div class="form-group">
                    <label for="customer_name">Nama Penerima</label>
                    <input type="text" id="customer_name" name="customer_name" class="form-control" value="{{ old('customer_name', Auth::user()->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="customer_address">Alamat Lengkap</label>
                    <textarea id="customer_address" name="customer_address" class="form-control" rows="4" required>{{ old('customer_address') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="customer_phone">Nomor Telepon</label>
                    <input type="text" id="customer_phone" name="customer_phone" class="form-control" value="{{ old('customer_phone') }}" required>
                </div>

                {{-- ======================================================= --}}
                {{-- PERBAIKAN: MENAMBAHKAN DROPDOWN PEMILIHAN EKSPEDISI --}}
                {{-- ======================================================= --}}
                <h3 style="margin-top: 40px;">2. Jasa Pengiriman</h3>
                <div class="form-group">
                    <label for="shipping_method">Pilih Jasa Pengiriman</label>
                    <select name="shipping_method" id="shipping_method" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Ekspedisi --</option>
                        <option value="J&T Express" @if(old('shipping_method') == 'J&T Express') selected @endif>J&T Express</option>
                        <option value="SiCepat" @if(old('shipping_method') == 'SiCepat') selected @endif>SiCepat</option>
                        <option value="Anteraja" @if(old('shipping_method') == 'Anteraja') selected @endif>Anteraja</option>
                        <option value="JNE" @if(old('shipping_method') == 'JNE') selected @endif>JNE</option>
                    </select>
                </div>

                <h3 style="margin-top: 40px;">3. Metode Pembayaran</h3>
                <div class="payment-options">
                    @php
                        $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);
                    @endphp

                    @if($total <= 500000)
                    <label style="display: block;">
                        <input type="radio" name="payment_method" value="qris" checked>
                        <div class="card">
                            <strong>QRIS</strong>
                            <p style="font-size: 0.9rem; margin: 5px 0 0 0;">Pembayaran instan. Untuk pesanan Rp 500.000 ke bawah.</p>
                        </div>
                    </label>
                    @endif

                    @if($total > 500000)
                    <label style="display: block;">
                        <input type="radio" name="payment_method" value="transfer" checked>
                        <div class="card">
                            <strong>Transfer Bank</strong>
                            <p style="font-size: 0.9rem; margin: 5px 0 0 0;">Transfer manual. Untuk pesanan di atas Rp 500.000.</p>
                        </div>
                    </label>
                    @endif
                </div>

                <button type="submit" class="btn btn-detail" style="width: 100%; padding: 15px; font-size: 1.1rem; margin-top: 30px;">
                    Buat Pesanan & Lanjut Pembayaran
                </button>
            </div>

            {{-- Kolom Kanan: Ringkasan Pesanan --}}
            <div class="order-summary">
                <h3>Ringkasan Pesanan</h3>
                @foreach($cartItems as $item)
                    <div class="summary-item">
                        <span>{{ \Illuminate\Support\Str::limit($item->description, 25) }} (x{{ $item->quantity }})</span>
                        <strong>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</strong>
                    </div>
                @endforeach
                <div class="summary-item summary-total">
                    <span>Total</span>
                    <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
