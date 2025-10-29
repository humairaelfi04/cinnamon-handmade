<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                        ->latest()
                        ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // Menampilkan halaman detail pesanan & form upload
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        return view('orders.show', compact('order'));
    }

    // Memproses upload bukti pembayaran
    public function pay(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('payment_proof')->store('proofs', 'public');

        $order->update([
            'payment_proof' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Bukti pembayaran Anda telah diunggah dan akan segera kami verifikasi.');
    }

    public function receive(Order $order)
    {
        // Keamanan: Pastikan hanya pemilik pesanan yang bisa mengubah
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // Hanya bisa diubah jika statusnya 'shipped' (dikirim)
        if ($order->status === 'shipped') {
            $order->update(['status' => 'completed']);

            // SARAN: Menggunakan redirect()->back() agar user tetap di halaman detail
            return redirect()->back()->with('success', 'Terima kasih telah mengonfirmasi. Pesanan telah selesai.');
        }

        return redirect()->back()->with('error', 'Status pesanan tidak dapat diubah.');
    }

}
