<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Menampilkan halaman galeri yang berisi ulasan-ulasan dari produk custom.
     */
    public function index()
    {
        $customProduct = Product::where('name', 'Produk Custom Rakitan')->first();

        if (!$customProduct) {
            $reviews = collect();
        } else {
            // PERUBAHAN: Menambahkan ->where('is_visible', true) untuk menyaring ulasan
            $reviews = $customProduct->reviews()
                                     ->where('is_visible', true)
                                     ->with('user')
                                     ->latest()
                                     ->paginate(9);
        }

        return view('gallery.index', compact('reviews'));
    }
}

