<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Carbon\Carbon; // Penting untuk bekerja dengan tanggal

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan ringkasan data bisnis.
     */
    public function index()
    {
        // --- 1. DATA PENJUALAN ---
        // Menghitung total pendapatan dari pesanan yang sudah 'completed' bulan ini
        $salesThisMonth = Order::where('status', 'completed')
                               ->whereMonth('created_at', Carbon::now()->month)
                               ->whereYear('created_at', Carbon::now()->year)
                               ->sum('total_amount');

        // Menghitung jumlah total pesanan yang masuk bulan ini (semua status)
        $ordersThisMonthCount = Order::whereMonth('created_at', Carbon::now()->month)
                                     ->whereYear('created_at', Carbon::now()->year)
                                     ->count();

        // --- 2. DATA BAHAN BAKU ---
        // Mengambil bahan baku yang stoknya kritis (kurang dari atau sama dengan 10)
        $lowStockMaterials = RawMaterial::where('stock', '<=', 10)->get();

        // --- 3. DATA CUSTOMER ---
        // Mengambil 5 pelanggan terbaru yang pernah melakukan pemesanan
        $recentCustomers = User::where('role', 'customer') // Pastikan hanya mengambil customer
                               ->whereHas('orders') // Hanya user yang pernah order
                               ->withCount('orders') // Menghitung jumlah order untuk setiap user
                               ->latest() // Diurutkan dari yang terbaru mendaftar
                               ->take(5) // Ambil 5 teratas
                               ->get();

        // Mengirim semua data yang sudah dikumpulkan ke halaman view
        return view('admin.dashboard.index', compact(
            'salesThisMonth',
            'ordersThisMonthCount',
            'lowStockMaterials',
            'recentCustomers'
        ));
    }
}

