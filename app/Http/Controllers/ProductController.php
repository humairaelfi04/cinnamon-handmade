<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Tag; // <-- Tambahkan ini
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman katalog produk untuk customer.
     */
    public function index(Request $request)
    {
        // Query dasar untuk produk yang terlihat dan tipenya 'single' atau 'bundle'
        $query = Product::where('is_visible', true)->whereIn('type', ['single', 'bundle']);

        // Jika ada filter tag yang dipilih
        if ($request->has('tags')) {
            $tagIds = $request->tags;
            $query->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('tags.id', $tagIds);
            });
        }

        $products = $query->latest()->paginate(12);
        $tags = Tag::all()->groupBy('type');

        return view('products.index', compact('products', 'tags'));
    }

    /**
     * Menampilkan halaman detail untuk satu produk.
     */
    public function show(Product $product)
    {
        if (!$product->is_visible) {
            abort(404);
        }

        // Memuat relasi review dan user yang membuat review
        $product->load('reviews.user');

        // Jika produk yang dibuka adalah tipe 'bundle', muat juga relasi isi produknya
        if ($product->type === 'bundle') {
            $product->load('bundledProducts');
        }

        return view('products.show', compact('product'));
}
}
