<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Penjualan - {{ $period }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; }
        .header p { margin: 5px 0; color: #666; }
        .summary { margin-bottom: 20px; border: 1px solid #ddd; padding: 10px; }
        .summary p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Penjualan</h1>
        <p>Cinnamon Handmade</p>
        <p>Periode: {{ $period }}</p>
    </div>

    <div class="summary">
        <p><strong>Total Pendapatan:</strong> Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        <p><strong>Total Pesanan:</strong> {{ $totalOrders }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Nama Pelanggan</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th class="text-right">Total Belanja</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                    <td class="text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data penjualan untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
