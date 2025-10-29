<?php

namespace App\Http\Controllers;

use App\Models\Product; // Jangan lupa import model Product
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('is_visible', true)->latest()->paginate(10);

        // Mengirim data produk ke view 'home'
        return view('home', compact('products'));
    }
}
