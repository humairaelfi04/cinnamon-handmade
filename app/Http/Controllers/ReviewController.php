<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // <-- Tambahkan ini untuk mengelola file

class ReviewController extends Controller
{
    /**
     * Menampilkan form untuk menulis review.
     */
    public function create(Product $product, Order $order)
    {
        // Keamanan: Cek apakah user adalah pemilik order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Cek apakah produk ini sudah pernah direview untuk order ini
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('product_id', $product->id)
                                ->where('order_id', $order->id)
                                ->exists();
        if ($existingReview) {
            return redirect()->route('orders.show', $order)->with('error', 'Anda sudah memberikan review untuk produk ini.');
        }

        return view('reviews.create', compact('product', 'order'));
    }

    /**
     * Menyimpan review baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // <-- Validasi untuk foto
        ]);

        $order = Order::findOrFail($request->order_id);
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Cek lagi untuk mencegah review ganda
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('product_id', $request->product_id)
                                ->where('order_id', $request->order_id)
                                ->exists();
        if ($existingReview) {
            return redirect()->route('orders.show', $order)->with('error', 'Anda sudah memberikan review untuk produk ini.');
        }

        $reviewData = [
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ];

        // ===============================================
        // LOGIKA BARU: MENANGANI UPLOAD FOTO
        // ===============================================
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('reviews', 'public');
            $reviewData['photo'] = $photoPath;
        }
        // ===============================================

        Review::create($reviewData);

        return redirect()->route('orders.show', $order)->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
