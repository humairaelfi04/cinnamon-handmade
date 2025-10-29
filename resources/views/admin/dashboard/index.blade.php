@extends('admin.layouts.app')

@section('title', 'Dashboard Insight')

@push('styles')
<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* Membuat 2 kolom */
        gap: 25px;
    }
    .stats-card {
        background-color: var(--white-card);
        padding: 25px;
        border-radius: 12px;
        border-left: 5px solid var(--primary-brown);
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .stats-card .title {
        font-size: 0.9rem;
        color: #6c757d;
        text-transform: uppercase;
        margin: 0 0 10px 0;
    }
    .stats-card .value {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0;
    }
    .info-card {
        grid-column: 1 / -1; /* Membuat kartu ini mengambil lebar penuh 2 kolom */
        background-color: var(--white-card);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .info-card h3 {
        margin-top: 0;
        border-bottom: 1px solid var(--light-border);
        padding-bottom: 10px;
    }
    .info-card table {
        margin-top: 0; /* Override style default */
    }
    .info-card th, .info-card td {
        border: none;
        border-bottom: 1px solid var(--light-border);
    }
    .info-card tr:last-child td {
        border-bottom: none;
    }
    .stock-low {
        color: #e74c3c;
        font-weight: bold;
    }

    /* Responsif untuk layar kecil */
    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr; /* 1 kolom di mobile */
        }
    }
</style>
@endpush

@section('content')
    <div class="page-header" style="border-bottom: none;">
        <h1>Dashboard Insight</h1>
        <small>Ringkasan Bisnis Bulan {{ Carbon\Carbon::now()->translatedFormat('F Y') }}</small>
    </div>

    {{-- Kartu Statistik Utama --}}
    <div class="dashboard-grid" style="margin-top: 20px;">
        <div class="stats-card">
            <p class="title">Total Pendapatan (Bulan Ini)</p>
            <p class="value">Rp {{ number_format($salesThisMonth, 0, ',', '.') }}</p>
        </div>
        <div class="stats-card">
            <p class="title">Jumlah Pesanan (Bulan Ini)</p>
            <p class="value">{{ $ordersThisMonthCount }}</p>
        </div>
    </div>

    {{-- Kartu Info Tambahan --}}
    <div style="margin-top: 25px;" class="dashboard-grid">
        {{-- Bahan Baku Kritis --}}
        <div class="info-card" style="grid-column: 1 / span 1;">
            <h3>Bahan Baku Kritis (Stok ≤ 10)</h3>
            @if($lowStockMaterials->isNotEmpty())
                <table>
                    <tbody>
                        @foreach($lowStockMaterials as $material)
                            <tr>
                                <td>{{ $material->name }}</td>
                                <td class="stock-low" style="text-align: right;">Sisa {{ (float)$material->stock }} {{ $material->unit }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>👍 Semua stok bahan baku aman.</p>
            @endif
        </div>

        {{-- Pelanggan Terbaru --}}
        <div class="info-card" style="grid-column: 2 / span 1;">
            <h3>Pelanggan Terbaru</h3>
            @if($recentCustomers->isNotEmpty())
                <table>
                    <tbody>
                        @foreach($recentCustomers as $customer)
                            <tr>
                                <td>
                                    <strong>{{ $customer->name }}</strong><br>
                                    <small>{{ $customer->email }}</small>
                                </td>
                                <td style="text-align: right;">{{ $customer->orders_count }} Pesanan</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Belum ada pelanggan yang terdaftar.</p>
            @endif
        </div>
    </div>
@endsection
