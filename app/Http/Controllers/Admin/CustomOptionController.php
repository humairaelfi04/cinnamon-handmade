<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomOption;
use Illuminate\Http\Request;

class CustomOptionController extends Controller
{
    public function index()
    {
        $customOptions = CustomOption::orderBy('id','asc')->paginate(10);
        return view('admin.custom_options.index', compact('customOptions'));
    }

    public function create()
    {
        return view('admin.custom_options.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:custom_options,name',
            'price' => 'required|numeric|min:0',
        ]);

        CustomOption::create($request->all());

        return redirect()->route('admin.custom-options.index')->with('success', 'Opsi kustom berhasil ditambahkan.');
    }

    public function edit(CustomOption $customOption)
    {
        return view('admin.custom_options.edit', compact('customOption'));
    }

    public function update(Request $request, CustomOption $customOption)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:custom_options,name,' . $customOption->id,
            'price' => 'required|numeric|min:0',
        ]);

        $customOption->update($request->all());

        return redirect()->route('admin.custom-options.index')->with('success', 'Opsi kustom berhasil diperbarui.');
    }

    public function destroy(CustomOption $customOption)
    {
        $customOption->delete();
        return redirect()->route('admin.custom-options.index')->with('success', 'Opsi kustom berhasil dihapus.');
    }
}
