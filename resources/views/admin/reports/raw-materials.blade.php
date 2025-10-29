@extends('admin.layouts.app')
@section('title', 'Laporan Bahan Baku')

@section('content')
    <div class="page-header">
        <h1>Laporan Bahan Baku</h1>
        <a href="{{ route('admin.reports.raw-materials.pdf') }}" class="btn" style="background-color: #27ae60;" target="_blank">Cetak Stok PDF</a>
    </div>

    <div class="summary-grid">
        <div class="summary-card">
            <h4>Total Nilai Inventaris</h4>
            <p class="summary-value">Rp {{ number_format($totalValue, 0, ',', '.') }}</p>
        </div>
        <div class="summary-card">
            <h4>Item Stok Menipis (< {{ $lowStockThreshold }})</h4>
            <p class="summary-value" style="color: #e74c3c;">{{ $lowStockItems->count() }}</p>
        </div>
        <div class="summary-card">
            <h4>Jumlah Jenis Bahan</h4>
            <p class="summary-value">{{ $totalTypes }}</p>
        </div>
    </div>

    <h4 class="table-header">Daftar Bahan Baku dengan Stok Menipis</h4>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama Bahan</th>
                    <th>Sisa Stok</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lowStockItems as $item)
                    <tr>
                        <td><strong>{{ $item->name }}</strong></td>
                        <td style="color: #e74c3c; font-weight: bold;">{{ (float)$item->stock }}</td>
                        <td>{{ $item->unit }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 20px;">Hebat! Tidak ada bahan baku yang stoknya menipis.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@push('styles')
<style>
    .summary-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px; }
    .summary-card { background-color: var(--cream-bg); padding: 20px; border-radius: 8px; text-align: center; }
    .summary-card h4 { margin-top: 0; margin-bottom: 10px; font-weight: 500; }
    .summary-value { font-size: 2rem; font-weight: 700; color: var(--primary-brown); margin: 0; }
    .table-header { margin-bottom: -10px; }
</style>
@endpush
