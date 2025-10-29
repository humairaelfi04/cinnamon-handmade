<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // <-- Import Rule untuk validasi

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('id', 'asc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $singleProducts = Product::where('type', 'single')->orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'tags', 'singleProducts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(['single', 'bundle'])],
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_visible' => 'required|boolean',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'bundled_products' => 'nullable|array',
            'bundled_products.*' => 'exists:products,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($validated);

        // Jika tipenya bundle, simpan relasi produk-produk isinya
        if ($validated['type'] === 'bundle' && !empty($validated['bundled_products'])) {
            $product->bundledProducts()->sync($validated['bundled_products']);
        }

        // Simpan relasi tag
        if (!empty($validated['tags'])) {
            $product->tags()->sync($validated['tags']);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $singleProducts = Product::where('type', 'single')->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'tags', 'singleProducts'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(['single', 'bundle'])],
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_visible' => 'required|boolean',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'bundled_products' => 'nullable|array',
            'bundled_products.*' => 'exists:products,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        // Update relasi untuk bundle
        if ($validated['type'] === 'bundle' && !empty($validated['bundled_products'])) {
            $product->bundledProducts()->sync($validated['bundled_products']);
        } else {
            // Jika diubah kembali menjadi single, hapus semua relasi bundle-nya
            $product->bundledProducts()->sync([]);
        }

        // Update relasi tag
        if (!empty($validated['tags'])) {
            $product->tags()->sync($validated['tags']);
        } else {
            $product->tags()->sync([]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
