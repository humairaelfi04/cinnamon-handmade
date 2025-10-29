@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')
@section('title', 'Detail Pesanan ' . $order->id)

@section('content')
<div class="container" style="max-width: 800px;">

    @if (session('success'))
        <div class="alert alert-success"> {{ session('success') }} </div>
    @endif
     @if (session('error'))
        <div class="alert alert-danger"> {{ session('error') }} </div>
    @endif

    <div class="card" style="background-color: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">

        @if (session()->has('success') && Str::contains(session('success'), 'verifikasi'))
            <div style="text-align: center;">
                <h3>Terima Kasih, Pesanan Anda Akan Segera Kami Proses!</h3>
                <p>Kami sedang memverifikasi pembayaran Anda. Anda bisa memantau status pesanan di halaman ini atau di "Pesanan Saya".</p>
                <hr class="separator">
            </div>
        @endif

        <div class="order-header">
            <h3>Detail Pesanan {{ $order->id }}</h3>
            <span class="status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
        </div>
        <hr class="separator">

        <h4>Alamat Pengiriman</h4>
        <div class="shipping-details">
            <p><strong>{{ $order->customer_name }}</strong></p>
            <p>{{ $order->customer_phone }}</p>
            <p>{{ $order->customer_address }}</p>
        </div>

        @if($order->tracking_number)
        <hr class="separator">
        <h4>Informasi Pengiriman</h4>
        <div class="shipping-details">
            <p><strong>Nomor Resi:</strong> {{ $order->tracking_number }}</p>
            <p>Silakan lacak pesanan Anda melalui situs resmi ekspedisi pilihan Anda.</p>
        </div>
        @endif

        <hr class="separator">

        <h4>Produk yang Dipesan</h4>
        <table class="products-table">
              <tbody>
                 @foreach($order->items as $item)
                  <tr>
                     <td style="width: 80px;">
                         @if($item->product_id && $item->product)
                             <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/80' }}" alt="{{ $item->description }}">
                         @else
                             @php
                                 $firstComponent = Str::before(Str::after($item->description, ': '), ' ');
                                 $imageText = Str::limit($firstComponent, 8, '');
                                 $bgColor = '#EAE0C8';
                                 if (Str::contains(Str::lower($item->description), ['batu', 'akik'])) { $bgColor = '#BDBBB0'; }
                                 elseif (Str::contains(Str::lower($item->description), 'benang')) { $bgColor = '#A07855'; }
                                 elseif (Str::contains(Str::lower($item->description), ['ukir', 'nama', 'charm'])) { $bgColor = '#D4AF37'; }
                             @endphp
                             <x-placeholder-image :text="$imageText" :bgColor="$bgColor" />
                         @endif
                     </td>
                     <td>
                         <strong>{!! nl2br(e($item->description)) !!}</strong>
                         <br>
                         <small>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                         @if($order->status == 'completed' && $item->product_id)
                             <a href="{{ route('reviews.create', ['product' => $item->product_id, 'order' => $order->id]) }}" class="btn-review">Beri Ulasan</a>
                         @endif
                     </td>
                     <td style="text-align: right;"><strong>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</strong></td>
                  </tr>
                  @endforeach
                  <tr class="total-row">
                     <td colspan="2"><strong>Total Pembayaran</strong></td>
                     <td style="text-align: right;"><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                  </tr>
              </tbody>
        </table>
        <hr class="separator">

        @if(!$order->payment_proof)
            @if($order->payment_method == 'transfer')
                <h4>Instruksi Transfer Bank</h4>
                <div class="payment-details">
                    <p><strong>Bank Nagari</strong> | No. Rek: <strong>21020210489714</strong> | A/N: <strong>Oryza Conseva</strong></p>
                </div>
            @elseif($order->payment_method == 'qris')
                <h4>Instruksi Pembayaran QRIS</h4>
                <img src="{{ asset('images/qris.png') }}" alt="Kode QRIS" class="qris-image">
            @endif
            <h4 style="margin-top: 20px;">Unggah Bukti Pembayaran</h4>
            <form action="{{ route('orders.pay', $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="file" name="payment_proof" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-detail">Saya Sudah Bayar</button>
            </form>
        @else
            <h4>Bukti Pembayaran</h4>
            <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Pembayaran" style="max-width: 200px; border-radius: 8px; border: 1px solid var(--light-border);">
            </a>
        @endif

        @if($order->status == 'shipped')
            <hr class="separator">
            <div style="text-align: center;">
                <p>Paket sudah dikirim. Jika sudah Anda terima, silakan konfirmasi.</p>
                <form action="{{ route('orders.receive', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-detail" style="background-color: #27ae60;">Pesanan Diterima</button>
                </form>
            </div>
        @endif

        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('orders.index') }}" class="btn btn-outline">Lihat Semua Pesanan</a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.alert-success, .alert-danger { padding: 15px; border-radius: 6px; margin-bottom: 20px; }
.alert-success { background-color: #d4edda; color: #155724; }
.alert-danger { background-color: #f8d7da; color: #721c24; }
.order-header { display: flex; justify-content: space-between; align-items: center; }
.separator { border: none; border-top: 1px solid var(--light-border); margin: 30px 0; }
.shipping-details p { margin: 5px 0; }
.products-table { width: 100%; border-collapse: collapse; }
.products-table td { padding: 15px 0; border-bottom: 1px solid var(--light-border); vertical-align: middle; }
.products-table tr:last-child td { border-bottom: none; }
.products-table img, .products-table svg { width: 60px; height: 60px; border-radius: 6px; object-fit: cover; margin-right: 15px; flex-shrink: 0; }
.total-row { font-size: 1.2rem; font-weight: bold; }
.status { padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-transform: capitalize; }
.status-pending { background-color: #FFF3CD; color: #856404; }
.status-processing { background-color: #D1ECF1; color: #0C5460; }
.status-shipped { background-color: #a7d7c5; color: #276749; }
.status-completed { background-color: #e9ecef; color: #495057; }
.status-cancelled { background-color: #F8D7DA; color: #721C24; }
.payment-details { background-color: var(--cream-bg); padding: 15px; border-radius: 8px; text-align: center; }
.qris-image { max-width: 250px; margin: 10px auto; display: block; border: 1px solid var(--light-border); padding: 10px; }
.btn-outline { background-color: transparent; color: var(--primary-brown); border: 2px solid var(--primary-brown); }
.btn-review { font-size: 0.8rem; padding: 4px 8px; display: inline-block; margin-top: 10px; border-radius: 4px; color: var(--primary-brown); border: 1px solid var(--primary-brown); text-decoration: none; }
</style>
@endpush
