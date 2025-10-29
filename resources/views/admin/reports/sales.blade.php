@extends('admin.layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
    <div class="page-header">
        <h1>Laporan Penjualan</h1>
        <a href="{{ route('admin.reports.sales.pdf') }}" class="btn" style="background-color: #27ae60;" target="_blank">Cetak PDF Bulan Ini</a>
    </div>

    <div class="summary-grid">
        <div class="summary-card">
            <h4>Total Pendapatan (Bulan Ini)</h4>
            <p class="summary-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="summary-card">
            <h4>Total Pesanan (Bulan Ini)</h4>
            <p class="summary-value">{{ $totalOrders }}</p>
        </div>
    </div>

    <h4 class="table-header">Rincian Transaksi Bulan Ini</h4>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Total Belanja</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td><strong>{{ $order->id }}</strong></td>
                        <td>{{ $order->customer_name }}</td>
                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>
                            <span class="status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary">Lihat Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">Belum ada data penjualan untuk bulan ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@push('styles')
<style>
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }
    .summary-card {
        background-color: var(--cream-bg);
        padding: 20px;
        border-radius: 8px;
        text-align: center;
    }
    .summary-card h4 {
        margin-top: 0;
        margin-bottom: 10px;
        font-weight: 500;
        color: var(--dark-text);
    }
    .summary-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-brown);
        margin: 0;
    }
    .table-header {
        margin-bottom: -10px;
    }
    .status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: capitalize;
    }
    .status-pending { background-color: #FFF3CD; color: #856404; }
    .status-processing { background-color: #D1ECF1; color: #0C5460; }
    .status-shipped { background-color: #a7d7c5; color: #276749; }
    .status-completed { background-color: #e9ecef; color: #495057; }
    .status-cancelled { background-color: #F8D7DA; color: #721C24; }
</style>
@endpush
