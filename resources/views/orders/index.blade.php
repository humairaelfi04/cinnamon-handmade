@extends('layouts.app')

@section('title', 'Riwayat Pesanan Saya')

@section('content')
<div class="container">
    <h1>Riwayat Pesanan Saya</h1>
    <p>Di sini Anda dapat melihat semua transaksi yang pernah Anda lakukan.</p>

    <div class="card" style="background-color: white; padding: 30px; border-radius: 12px; margin-top: 30px;">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td><strong>{{ $order->id }}</strong></td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-detail">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px;">Anda belum memiliki riwayat pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top: 20px;">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Style ini dibutuhkan untuk label status */
table { width: 100%; border-collapse: collapse; }
th, td { border-bottom: 1px solid var(--light-border); padding: 15px; text-align: left; vertical-align: middle; }
th { font-weight: 700; }
.status { padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-transform: capitalize; }
.status-pending { background-color: #FFF3CD; color: #856404; }
.status-processing { background-color: #D1ECF1; color: #0C5460; }
.status-shipped { background-color: #C3E6CB; color: #155724; }
.status-completed { background-color: #C3E6CB; color: #155724; }
.status-cancelled { background-color: #F8D7DA; color: #721C24; }
</style>
@endpush
