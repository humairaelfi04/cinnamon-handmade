<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect('register')->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Logika Sinkronisasi Keranjang Session (jika ada)
            $sessionCart = session()->get('cart', []);
            if (!empty($sessionCart)) {
                foreach ($sessionCart as $productId => $details) {
                    $cartItem = Cart::firstOrNew([
                        'user_id' => Auth::id(),
                        'product_id' => $productId,
                    ]);
                    $cartItem->quantity += $details['quantity'];
                    $cartItem->save();
                }
                session()->forget('cart');
            }

            // Logika Baru: Menjalankan Aksi yang Tertunda (jika ada)
            if (session()->has('pending_cart_addition')) {
                $data = session('pending_cart_addition');
                session()->forget('pending_cart_addition');

                $product = Product::find($data['product_id']);
                if ($product) {
                    $cartItem = Cart::firstOrNew([
                        'user_id' => Auth::id(),
                        'product_id' => $data['product_id'],
                    ]);
                    $cartItem->quantity += $data['quantity'];
                    $cartItem->price = $product->price;
                    $cartItem->description = $product->name;
                    $cartItem->save();
                }

                return redirect()->route('cart.index')->with('success', 'Login berhasil dan produk telah ditambahkan ke keranjang Anda!');
            }

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/products');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
