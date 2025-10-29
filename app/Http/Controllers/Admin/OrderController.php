<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    // === PENYEMPURNAAN DI METHOD INI ===
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $order->status = $request->status;

        // Simpan nomor resi jika status 'shipped'
        if ($request->status === 'shipped') {
            $order->tracking_number = $request->tracking_number;
        } else {
            // PERBAIKAN: Hapus nomor resi jika status BUKAN 'shipped'
            // Ini untuk mengatasi kasus jika admin salah input dan mengubah status kembali.
            $order->tracking_number = null;
        }

        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
