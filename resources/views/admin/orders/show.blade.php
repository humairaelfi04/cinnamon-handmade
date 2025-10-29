@extends('admin.layouts.app')
@section('title', 'Detail Pesanan ' . $order->id)

@section('content')
    <div class="page-header">
        <h1>Detail Pesanan {{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn" style="background-color: #6c757d; color: white;">Kembali</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="padding: 15px; background-color: #d4edda; margin-bottom: 20px; border-radius: 6px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Grid untuk detail pelanggan dan pesanan --}}
    <div class="order-details-grid">
        <div class="detail-card">
            <h4>Detail Pelanggan</h4>
            <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
            <p><strong>Email:</strong> {{ $order->user->email }}</p>
            <p><strong>Telepon:</strong> {{ $order->customer_phone }}</p>
            <p><strong>Alamat:</strong><br>{{ $order->customer_address }}</p>
        </div>
        <div class="detail-card">
            <h4>Detail Pesanan</h4>
            <p><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
            <p><strong>Total Pembayaran:</strong> <strong style="color: var(--primary-brown);">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>

            {{-- ====================================================== --}}
            {{-- PERBAIKAN: MENAMPILKAN EKSPEDISI YANG DIPILIH CUSTOMER --}}
            {{-- ====================================================== --}}
            @if($order->shipping_method)
                <p><strong>Pilihan Ekspedisi:</strong>
                    <span style="font-weight: bold; color: #007bff; background-color: #e7f3ff; padding: 3px 8px; border-radius: 4px;">
                        {{ $order->shipping_method }}
                    </span>
                </p>
            @endif

            @if($order->payment_proof)
                <p><strong>Bukti Bayar:</strong></p>
                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                    <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Pembayaran" style="max-width: 150px; border-radius: 6px;">
                </a>
            @else
                <p><strong>Bukti Bayar:</strong> <span style="color: #e74c3c;">Belum diunggah</span></p>
            @endif
        </div>
    </div>

    {{-- Card untuk mengubah status pesanan --}}
    <div class="detail-card" style="margin-top: 20px;">
        <h4>Ubah Status Pesanan</h4>

        @if(!in_array($order->status, ['completed', 'cancelled']))
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status-select" class="form-control">
                        <option value="pending" @if($order->status == 'pending') selected @endif>Pending</option>
                        <option value="processing" @if($order->status == 'processing') selected @endif>Diproses</option>
                        <option value="shipped" @if($order->status == 'shipped') selected @endif>Dikirim</option>
                        <option value="completed" @if($order->status == 'completed') selected @endif>Selesai</option>
                        <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Dibatalkan</option>
                    </select>
                </div>

                <div class="form-group" id="tracking-number-wrapper" style="display: none;">
                    <label for="tracking_number">Nomor Resi Pengiriman</label>
                    <input type="text" name="tracking_number" class="form-control" value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="Masukkan nomor resi...">
                </div>

                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        @else
            <p>Status pesanan sudah <strong>{{ ucfirst($order->status) }}</strong> dan tidak dapat diubah lagi.</p>
            @if($order->tracking_number)
                <p><strong>Nomor Resi:</strong> {{ $order->tracking_number }}</p>
            @endif
        @endif
    </div>

    {{-- Tabel untuk item yang dipesan --}}
    <h4 style="margin-top: 30px;">Item yang Dipesan</h4>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 80px;"></th>
                    <th>Deskripsi Produk</th>
                    <th style="text-align: center;">Kuantitas</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>
                            @if($item->product_id && $item->product)
                                <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/80' }}" alt="" style="width: 60px; height: 60px; border-radius: 6px; object-fit: cover;">
                            @else
                                <x-placeholder-image text="Custom" />
                            @endif
                        </td>
                        <td>
                            <strong>{{ $item->description }}</strong>
                            <br>
                            <small>Harga Satuan: Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                        </td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('styles')
<style>
.order-details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.detail-card { background-color: var(--cream-bg); padding: 20px; border-radius: 8px; }
.form-group { margin-bottom: 1.5rem; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status-select');
        const trackingWrapper = document.getElementById('tracking-number-wrapper');

        if (statusSelect && trackingWrapper) {
            function toggleTrackingInput() {
                if (statusSelect.value === 'shipped') {
                    trackingWrapper.style.display = 'block';
                } else {
                    trackingWrapper.style.display = 'none';
                }
            }
            toggleTrackingInput();
            statusSelect.addEventListener('change', toggleTrackingInput);
        }
    });
</script>
@endpush
