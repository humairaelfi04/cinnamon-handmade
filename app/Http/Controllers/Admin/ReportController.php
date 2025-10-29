<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\RawMaterial; // <-- Tambahkan ini
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        // Ambil semua pesanan yang statusnya tidak 'cancelled'
        $orders = Order::where('status', '!=', 'cancelled')->latest()->get();

        // Hitung total pendapatan
        $totalRevenue = $orders->sum('total_amount');

        // Hitung jumlah pesanan
        $totalOrders = $orders->count();

        return view('admin.reports.sales', compact('orders', 'totalRevenue', 'totalOrders'));
    }

    public function rawMaterialsPdf()
    {
        // 1. Mengurutkan berdasarkan ID terkecil
        $rawMaterials = RawMaterial::orderBy('id', 'asc')->get();
        $date = now()->format('d F Y');

        // 2. Menambahkan logika perhitungan ringkasan (sama seperti di halaman web)
        $totalValue = $rawMaterials->sum(function($item) {
            return $item->stock * $item->price;
        });
        $lowStockThreshold = 20;
        $lowStockItemsCount = $rawMaterials->where('stock', '<', $lowStockThreshold)->count();
        $totalTypes = $rawMaterials->count();

        // 3. Mengirim semua data ringkasan ke view PDF
        $pdf = Pdf::loadView('admin.reports.pdf.raw-materials', [
            'rawMaterials' => $rawMaterials,
            'date' => $date,
            'totalValue' => $totalValue,
            'lowStockItemsCount' => $lowStockItemsCount,
            'totalTypes' => $totalTypes,
        ]);

        return $pdf->download('laporan-bahan-baku-' . now()->format('Y-m-d') . '.pdf');
    }

    public function salesPdf(Request $request)
    {
        // Ambil data hanya untuk bulan dan tahun saat ini
        $month = now()->month;
        $year = now()->year;

        $orders = Order::whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->where('status', '!=', 'cancelled')
                    ->get();

        $totalRevenue = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        $period = now()->format('F Y');

        $pdf = Pdf::loadView('admin.reports.pdf.sales', compact('orders', 'totalRevenue', 'totalOrders', 'period'));

        return $pdf->download('laporan-penjualan-' . now()->format('Y-m') . '.pdf');
    }

    public function rawMaterialsReport()
    {
        $rawMaterials = RawMaterial::all();

        // 1. Hitung Total Nilai Inventaris
        $totalValue = $rawMaterials->sum(function($item) {
            return $item->stock * $item->price;
        });

        // 2. Filter Item Stok Menipis (misalnya, di bawah 20)
        $lowStockThreshold = 20;
        $lowStockItems = $rawMaterials->where('stock', '<', $lowStockThreshold);

        // 3. Hitung Jumlah Jenis Bahan
        $totalTypes = $rawMaterials->count();

        return view('admin.reports.raw-materials', compact(
            'totalValue',
            'lowStockItems',
            'totalTypes',
            'lowStockThreshold'
        ));
    }
}
