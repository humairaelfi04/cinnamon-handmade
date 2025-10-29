<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // ... (method index, update, remove tetap sama seperti sebelumnya) ...
    public function index()
    {
        $cartItems = collect();
        $total = 0;
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
            $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        }
        return view('cart.index', compact('cartItems', 'total'));
    }

    // === METHOD INI YANG KITA UBAH SECARA TOTAL ===
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if (!Auth::check()) {
            session(['pending_cart_addition' => $request->all()]);
            return redirect()->route('login')->with('error', 'Anda harus login untuk menambahkan barang ke keranjang.');
        }

        // Ambil produk yang ingin ditambahkan (bisa single, bisa bundle)
        $productToAdd = Product::findOrFail($request->product_id);

        // Cek apakah item ini (berdasarkan product_id) sudah ada di keranjang user
        $cartItem = Cart::where('user_id', Auth::id())
                    ->where('product_id', $productToAdd->id)
                    ->first();

        if ($cartItem) {
            // Jika sudah ada, cukup tambahkan kuantitasnya
            $cartItem->increment('quantity', $request->quantity);
        }   else {
            // Jika belum ada, buat item baru di keranjang
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productToAdd->id, // Simpan ID produknya (baik itu single/bundle)
                'quantity' => $request->quantity,
                'price' => $productToAdd->price, // Ambil harga dari produk itu sendiri
                'description' => $productToAdd->name, // Ambil nama produk/bundle
        ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, $cartId)
    {
        if (Auth::check()) {
            $cartItem = Cart::where('id', $cartId)->where('user_id', Auth::id())->firstOrFail();
            if ($cartItem->product_id) {
                $cartItem->update(['quantity' => $request->quantity]);
            }
        }
        return redirect()->back()->with('success', 'Keranjang berhasil diperbarui!');
    }

    public function remove($cartId)
    {
        if (Auth::check()) {
            Cart::where('id', $cartId)->where('user_id', Auth::id())->delete();
        }
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}
