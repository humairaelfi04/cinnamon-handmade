<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product; // <-- Pastikan Product di-import
use App\Models\RawMaterial;
use App\Models\CustomOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductBuilderController extends Controller
{
    /**
     * Menampilkan halaman product builder interaktif.
     */
    public function index()
    {
        $allRawMaterials = RawMaterial::all();
        $bahanKerangka = $allRawMaterials->where('material_type', 'Kerangka');
        $batuAlam = $allRawMaterials->where('material_type', 'Batu Alam');
        $customOptions = CustomOption::all();

        return view('product_builder.index', compact('bahanKerangka', 'batuAlam', 'customOptions'));
    }

    /**
     * Menambahkan produk custom ke keranjang belanja.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'kerangka_id' => 'required|exists:raw_materials,id',
            'batu_id' => 'required|exists:raw_materials,id',
            'addon_details.*' => 'nullable|string|max:100'
        ], [
            'kerangka_id.required' => 'Anda harus memilih bahan kerangka.',
            'batu_id.required' => 'Anda harus memilih batu alam.',
        ]);

        // ===============================================
        // LOGIKA BARU: CARI PRODUK INDUK
        // ===============================================
        $customProductTemplate = Product::where('name', 'Produk Custom Rakitan')->first();

        // Pengaman jika admin lupa membuat produk induk
        if (!$customProductTemplate) {
            return redirect()->back()->with('error', 'Fitur custom order belum siap. Harap hubungi admin.');
        }
        // ===============================================

        $totalPrice = 0;
        $description = "Custom Order:\n";

        $kerangka = RawMaterial::find($request->kerangka_id);
        $totalPrice += $kerangka->price;
        $description .= "- Kerangka: " . $kerangka->name . "\n";

        $batu = RawMaterial::find($request->batu_id);
        $totalPrice += $batu->price;
        $description .= "- Batu Alam: " . $batu->name . "\n";

        if ($request->has('custom_options')) {
            $description .= "\nTambahan:\n";
            foreach ($request->custom_options as $optionId) {
                $option = CustomOption::find($optionId);
                if ($option) {
                    $totalPrice += $option->price;
                    $detailText = $request->input("addon_details.{$optionId}");
                    if ($detailText) {
                        $description .= "- " . $option->name . ": \"" . e($detailText) . "\"\n";
                    } else {
                        $description .= "- " . $option->name . "\n";
                    }
                }
            }
        }

        // Simpan ke keranjang
        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $customProductTemplate->id, // <-- PERUBAHAN DI SINI
            'quantity' => 1,
            'price' => $totalPrice,
            'description' => trim($description)
        ]);

        return redirect()->route('cart.index')->with('success', 'Produk custom berhasil ditambahkan ke keranjang!');
    }
}
