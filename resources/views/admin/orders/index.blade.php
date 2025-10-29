@extends('admin.layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
    <div class="page-header">
        <h1>Daftar Pesanan Masuk</h1>
    </div>

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
                        <td colspan="6" style="text-align: center; padding: 20px;">Belum ada pesanan yang masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Link Paginasi --}}
    <div class="pagination-wrapper">
        {{ $orders->links() }}
    </div>
@endsection

@push('styles')
<style>
    .table-responsive { overflow-x: auto; }
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
    .status-completed { background-color: #e9ecef; color: #495057; }
    .status-cancelled { background-color: #F8D7DA; color: #721C24; }

    /* === CSS BARU UNTUK PAGINASI === */
    .pagination-wrapper {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }
    .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: .25rem;
    }
    .page-item .page-link {
        color: var(--primary-brown);
        background-color: #fff;
        border: 1px solid #dee2e6;
        padding: .5rem .9rem;
        text-decoration: none;
        transition: all 0.2s;
    }
    .page-item:first-child .page-link {
        border-top-left-radius: .25rem;
        border-bottom-left-radius: .25rem;
    }
    .page-item:last-child .page-link {
        border-top-right-radius: .25rem;
        border-bottom-right-radius: .25rem;
    }
    .page-item.active .page-link {
        z-index: 1;
        color: #fff;
        background-color: var(--primary-brown);
        border-color: var(--primary-brown);
    }
    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }
    .page-item .page-link:hover {
        background-color: var(--cream-bg);
    }
</style>
@endpush
