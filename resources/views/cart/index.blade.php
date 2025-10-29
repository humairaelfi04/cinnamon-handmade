@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')
@section('title', 'Keranjang Belanja Anda')

@push('styles')
<style>
/* Style Variabel (asumsikan ada di layout utama Anda) */
:root {
    --white-card: #ffffff;
    --primary-brown: #8D6E63;
    --light-border: #E0E0E0;
}

.container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
h1 { font-family: 'Playfair Display', serif; margin-bottom: 20px; }
.cart-container { background-color: var(--white-card); padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
.cart-table { width: 100%; border-collapse: collapse; }
.cart-table th, .cart-table td { padding: 15px; text-align: left; border-bottom: 1px solid var(--light-border); vertical-align: middle; }
.cart-table th { font-weight: 700; text-transform: uppercase; font-size: 0.9rem; }
.product-info-cell { display: flex; align-items: center; gap: 20px; }
.product-info-cell img, .product-info-cell svg { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; flex-shrink: 0; }
.quantity-input { width: 70px; text-align: center; padding: 8px; border: 1px solid var(--light-border); border-radius: 6px; }
.cart-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--light-border); }
.cart-summary { text-align: right; }
.cart-summary h4 { margin: 0 0 15px 0; font-weight: 500; font-size: 1.1rem; }
.cart-summary .total-price { font-size: 1.5rem; font-weight: 700; color: var(--primary-brown); }
.alert-success { padding: 15px; margin-bottom: 20px; border-radius: 6px; background-color: #E6F3EF; color: #6A9C89; border: 1px solid #6A9C89; }
.btn { padding: 10px 20px; border-radius: 6px; text-decoration: none; display: inline-block; font-weight: 500; transition: all 0.2s; }
.btn-outline { background-color: transparent; color: var(--primary-brown); border: 2px solid var(--primary-brown); }
.btn-outline:hover { background-color: var(--primary-brown); color: white; }
.btn-danger { background-color: #e74c3c; color: white; border: none; cursor: pointer; }
.btn-detail { background-color: #27ae60; color: white; border: none; cursor: pointer; }

/* Style BARU untuk isi bundle di keranjang */
.bundle-contents-in-cart {
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 8px;
    padding-left: 10px;
}
.bundle-contents-in-cart ul {
    list-style-type: none;
    padding-left: 0;
    margin: 5px 0 0 0;
    line-height: 1.5;
}
</style>
@endpush

@section('content')
<div class="container">
    <h1>Keranjang Belanja</h1>
    <div class="cart-container">
        @if (session('success'))
            <div class="alert-success"> {{ session('success') }} </div>
        @endif

        @if($cartItems->isNotEmpty())
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga Satuan</th>
                        <th style="text-align:center;">Kuantitas</th>
                        <th style="text-align:right;">Subtotal</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr data-price="{{ $item->price }}">
                            <td>
                                <div class="product-info-cell">
                                    @if($item->product_id && $item->product)
                                        <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://placehold.co/80x80/EAE0C8/3D3B30?text=Cinnamon' }}" alt="{{ $item->description }}">
                                    @else
                                        {{-- Placeholder untuk item custom order jika ada --}}
                                        <x-placeholder-image text="Custom" />
                                    @endif

                                    <div>
                                        <strong>{!! nl2br(e($item->description)) !!}</strong>

                                        {{-- ======================================================== --}}
                                        {{-- LOGIKA UNTUK MENAMPILKAN ISI BUNDLE --}}
                                        {{-- ======================================================== --}}
                                        @if ($item->product && $item->product->type === 'bundle' && $item->product->bundledProducts->isNotEmpty())
                                            <div class="bundle-contents-in-cart">
                                                <ul>
                                                @foreach ($item->product->bundledProducts as $subProduct)
                                                    <li>- {{ $subProduct->name }}</li>
                                                @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        {{-- ======================================================== --}}
                                        {{-- AKHIR DARI LOGIKA BUNDLE --}}
                                        {{-- ======================================================== --}}
                                    </div>
                                </div>
                            </td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td style="text-align:center;">
                                @if($item->product_id)
                                    <input type="number" value="{{ $item->quantity }}" class="quantity-input" data-id="{{ $item->id }}" min="1" max="{{ $item->product->stock }}">
                                @else
                                    {{ $item->quantity }}
                                @endif
                            </td>
                            <td style="text-align:right;" class="subtotal-display">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </td>
                            <td style="text-align:center;">
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="cart-actions">
                <a href="{{ route('home') }}" class="btn btn-outline">&larr; Lanjut Belanja</a>
                <div class="cart-summary">
                    <h4>Total Belanja: <span class="total-price" id="grand-total">Rp {{ number_format($total, 0, ',', '.') }}</span></h4>
                    <a href="{{ route('checkout.index') }}" class="btn btn-detail">Lanjut ke Checkout &rarr;</a>
                </div>
            </div>
        @else
            <div style="text-align: center; padding: 50px;">
                <h3>Keranjang Anda masih kosong.</h3>
                <a href="{{ route('home') }}" class="btn btn-detail" style="margin-top: 15px;">Mulai Belanja</a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ambil token CSRF dari meta tag untuk keamanan request
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Fungsi untuk memformat angka menjadi format Rupiah
    function formatRupiah(number) {
        return 'Rp ' + number.toLocaleString('id-ID');
    }

    // Fungsi untuk menghitung ulang dan menampilkan total keseluruhan belanja
    function updateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('tbody tr').forEach(row => {
            const price = parseFloat(row.dataset.price);
            const quantity = parseInt(row.querySelector('.quantity-input')?.value || 1);
            grandTotal += price * quantity;
        });
        document.getElementById('grand-total').textContent = formatRupiah(grandTotal);
    }

    // Tambahkan event listener ke setiap input kuantitas
    document.querySelectorAll('.quantity-input').forEach(input => {
        let debounceTimer;

        input.addEventListener('input', function() {
            clearTimeout(debounceTimer);

            const cartId = this.dataset.id;
            let quantity = parseInt(this.value);
            const maxStock = parseInt(this.getAttribute('max'));

            // Validasi agar kuantitas tidak melebihi stok
            if (quantity > maxStock) {
                alert('Stok tidak mencukupi! Sisa stok: ' + maxStock);
                quantity = maxStock;
                this.value = maxStock;
            }
            if (quantity < 1) {
                quantity = 1;
                this.value = 1;
            }

            // 1. Update tampilan subtotal per baris secara langsung
            const tableRow = this.closest('tr');
            const price = parseFloat(tableRow.dataset.price);
            const subtotalCell = tableRow.querySelector('.subtotal-display');
            subtotalCell.textContent = formatRupiah(price * quantity);

            // 2. Hitung ulang total keseluruhan
            updateGrandTotal();

            // 3. Kirim perubahan ke server setelah jeda 500ms (debounce)
            debounceTimer = setTimeout(() => {
                fetch(`/keranjang/update/${cartId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        quantity: quantity
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal mengupdate keranjang');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Keranjang berhasil diupdate di server!');
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Mungkin tampilkan pesan error ke user
                });
            }, 500);
        });
    });
});
</script>
@endpush
