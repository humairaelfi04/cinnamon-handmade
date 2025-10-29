<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Menampilkan daftar semua tag.
     */
    public function index()
    {
        $tags = Tag::orderBy('id', 'asc')->paginate(15);
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Menampilkan form untuk membuat tag baru.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Menyimpan tag baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
            'type' => 'required|string|max:255',
        ]);

        Tag::create($validatedData);

        return redirect()->route('admin.tags.index')
                         ->with('success', 'Tag baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit tag.
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Mengupdate tag yang ada di database.
     */
    public function update(Request $request, Tag $tag)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'type' => 'required|string|max:255',
        ]);

        $tag->update($validatedData);

        return redirect()->route('admin.tags.index')
                         ->with('success', 'Tag berhasil diperbarui.');
    }

    /**
     * Menghapus tag dari database.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tags.index')
                         ->with('success', 'Tag berhasil dihapus.');
    }
}
