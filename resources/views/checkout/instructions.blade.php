@extends('layouts.app')

@section('title', 'Instruksi Pembayaran')

@section('content')
<div class="container" style="max-width: 800px; text-align: center; margin-top: 50px; margin-bottom: 50px;">
    <div class="card" style="background-color: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">

        <h2>Terima Kasih Atas Pesanan Anda!</h2>
        <p>Pesanan Anda dengan ID <strong>#{{ $order->id }}</strong> telah kami terima dan menunggu pembayaran.</p>
        <p>Total yang harus dibayar: <strong style="font-size: 1.5rem; color: var(--primary-brown);">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
        <hr style="border: none; border-top: 1px solid var(--light-border); margin: 30px 0;">

        {{-- Jika metode pembayaran adalah 'transfer', tampilkan ini --}}
        @if($order->payment_method == 'transfer')
            <h3>Instruksi Transfer Bank</h3>
            <p>Silakan transfer ke rekening berikut:</p>
            <div style="background-color: var(--cream-bg); padding: 20px; border-radius: 8px; display: inline-block; text-align: left;">
                <p style="margin: 5px 0;"><strong>Bank Nagari</strong></p>
                <p style="margin: 5px 0;">No. Rekening: <strong>21020210489714</strong></p>
                <p style="margin: 5px 0;">Atas Nama: <strong>Oryza Conseva</strong></p>
            </div>
            <p style="margin-top: 20px; font-size: 0.9rem;">Pesanan Anda akan kami proses setelah pembayaran dikonfirmasi oleh admin.</p>

        {{-- Jika metode pembayaran adalah 'qris', tampilkan ini --}}
        @elseif($order->payment_method == 'qris')
            <h3>Instruksi Pembayaran QRIS</h3>
            <p>Silakan scan kode QR di bawah ini menggunakan aplikasi e-wallet Anda.</p>
            <div>
                {{-- Pastikan Anda sudah meletakkan gambar qris.png di folder public/images/ --}}
                <img src="{{ asset('images/qris.jpg') }}" alt="Kode QRIS" style="max-width: 300px; margin: auto; display: block; border: 1px solid var(--light-border); padding: 10px;">
            </div>
            <p style="margin-top: 20px; font-size: 0.9rem;">Pesanan Anda akan kami proses setelah pembayaran dikonfirmasi oleh admin.</p>
        @endif
        <a href="{{ route('home') }}" class="btn btn-detail" style="margin-top: 30px;">Kembali ke Homepage</a>
    </div>
</div>
@endsection
