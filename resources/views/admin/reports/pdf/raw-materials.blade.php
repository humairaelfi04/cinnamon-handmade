<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bahan Baku</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        .header p { margin: 5px 0; color: #666; }
        .summary { margin-bottom: 20px; border: 1px solid #ddd; padding: 10px; }
        .summary p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Stok Bahan Baku</h1>
        <p>Cinnamon Handmade - Dicetak pada {{ $date }}</p>
    </div>

    <div class="summary">
        <p><strong>Total Nilai Inventaris:</strong> Rp {{ number_format($totalValue, 0, ',', '.') }}</p>
        <p><strong>Jumlah Jenis Bahan:</strong> {{ $totalTypes }} item</p>
        <p><strong>Item Stok Menipis:</strong> {{ $lowStockItemsCount }} item</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Bahan</th>
                <th>Stok Saat Ini</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rawMaterials as $material)
                <tr>
                    <td>{{ $material->id }}</td>
                    <td>{{ $material->name }}</td>
                    <td>{{ (float)$material->stock }}</td>
                    <td>{{ $material->unit }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data bahan baku.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
