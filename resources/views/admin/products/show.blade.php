@extends('admin.layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
    <div class="page-header">
        <h1>Detail Pesanan #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn" style="background-color: #6c757d; color: white;">Kembali ke Daftar Pesanan</a>
    </div>

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
            <p><strong>Status:</strong> <span class="status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></p>
            <p><strong>Total Pembayaran:</strong></p>
            <h3 class="total-amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h3>
        </div>
    </div>

    <h4 class="items-header">Item yang Dipesan</h4>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga Satuan</th>
                    <th>Kuantitas</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>
                            <div class="product-info-cell">
                                <img src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/80' }}" alt="{{ $item->product->name ?? 'Produk Dihapus' }}" class="product-image">
                                <span>{{ $item->product->name ?? 'Produk Telah Dihapus' }}</span>
                            </div>
                        </td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>x {{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('styles')
<style>
    .status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: capitalize;
    }
    .status-pending { background-color: #FFF3CD; color: #856404; }
    .status-processing { background-color: #D1ECF1; color: #0C5460; }
    .status-shipped { background-color: #C3E6CB; color: #155724; }
    .status-completed { background-color: #C3E6CB; color: #155724; }
    .status-cancelled { background-color: #F8D7DA; color: #721C24; }

    .order-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .detail-card {
        background-color: var(--cream-bg);
        padding: 20px;
        border-radius: 8px;
    }
    .detail-card h4 {
        margin-top: 0;
        border-bottom: 1px solid var(--light-border);
        padding-bottom: 10px;
        margin-bottom: 15px;
    }
    .detail-card p {
        margin: 0 0 10px 0;
        line-height: 1.6;
    }
    .total-amount {
        color: var(--primary-brown);
        font-size: 1.5rem;
        font-weight: 700;
    }
    .items-header {
        margin-top: 40px;
        margin-bottom: -10px;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .product-info-cell {
        display: flex;
        align-items: center;
    }
    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 15px;
    }
</style>
@endpush
