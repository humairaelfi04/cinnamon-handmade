<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong untuk checkout!');
        }
        return view('checkout.index', compact('cartItems'));
    }

    public function process(Request $request)
    {
        // ======================================================
        // PERBAIKAN: MENAMBAHKAN VALIDASI UNTUK SHIPPING_METHOD
        // ======================================================
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string',
            'customer_phone' => 'required|string|max:20',
            'payment_method' => 'required|string',
            'shipping_method' => 'required|string|in:J&T Express,SiCepat,Anteraja,JNE', // Memastikan nilainya valid
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        $totalAmount = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        // Pengecekan stok
        foreach ($cartItems as $item) {
            if ($item->product_id && $item->product) {
                if ($item->product->stock < $item->quantity) {
                    return redirect()->route('cart.index')->with('error', 'Stok produk "' . $item->product->name . '" tidak mencukupi. Sisa stok: ' . $item->product->stock);
                }
            }
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_address' => $request->customer_address,
                'customer_phone' => $request->customer_phone,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                // ======================================================
                // PERBAIKAN: MENYIMPAN SHIPPING_METHOD KE DATABASE
                // ======================================================
                'shipping_method' => $request->shipping_method,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'description' => $item->description,
                ]);

                if ($item->product_id) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            Cart::where('user_id', Auth::id())->delete();
            DB::commit();

            return redirect()->route('orders.show', $order);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage())->withInput();
        }
    }
}
