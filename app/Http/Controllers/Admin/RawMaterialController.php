<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RawMaterialController extends Controller
{
    /**
     * Menampilkan daftar semua bahan baku.
     */
    public function index()
    {
        $rawMaterials = RawMaterial::orderBy('id','asc')->paginate(10);
        // PERBAIKAN: Menggunakan underscore agar sesuai nama folder
        return view('admin.raw_materials.index', compact('rawMaterials'));
    }

    /**
     * Menampilkan form untuk membuat bahan baku baru.
     */
    public function create()
    {
        // PERBAIKAN: Menggunakan underscore agar sesuai nama folder
        return view('admin.raw_materials.create');
    }

    /**
     * Menyimpan bahan baku baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:raw_materials,name',
            'price' => 'required|numeric|min:0',
            'accessory_type' => 'nullable|string',
            'material_type' => 'required|string',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('raw_materials', 'public');
        }

        RawMaterial::create($validatedData);

        return redirect()->route('admin.raw-materials.index')
                         ->with('success', 'Bahan baku berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit bahan baku.
     */
    public function edit(RawMaterial $rawMaterial)
    {
        // PERBAIKAN: Menggunakan underscore agar sesuai nama folder
        return view('admin.raw_materials.edit', compact('rawMaterial'));
    }

    /**
     * Mengupdate bahan baku yang ada di database.
     */
    public function update(Request $request, RawMaterial $rawMaterial)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:raw_materials,name,' . $rawMaterial->id,
            'price' => 'required|numeric|min:0',
            'accessory_type' => 'nullable|string',
            'material_type' => 'required|string',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($rawMaterial->image) {
                Storage::disk('public')->delete($rawMaterial->image);
            }
            $validatedData['image'] = $request->file('image')->store('raw_materials', 'public');
        }

        $rawMaterial->update($validatedData);

        return redirect()->route('admin.raw-materials.index')
                         ->with('success', 'Bahan baku berhasil diperbarui.');
    }

    /**
     * Menghapus bahan baku dari database.
     */
    public function destroy(RawMaterial $rawMaterial)
    {
        if ($rawMaterial->image) {
            Storage::disk('public')->delete($rawMaterial->image);
        }

        $rawMaterial->delete();

        return redirect()->route('admin.raw-materials.index')
                         ->with('success', 'Bahan baku berhasil dihapus.');
    }
}
