<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Menampilkan daftar semua ulasan dari pelanggan.
     */
    public function index()
    {
        // Mengambil semua ulasan, diurutkan dari yang terbaru
        // Menggunakan 'with' untuk mengambil data relasi (user & product) agar lebih efisien
        $reviews = Review::with(['user', 'product'])->latest()->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Mengubah status visibilitas (tampil/sembunyi) sebuah ulasan.
     */
    public function toggleVisibility(Review $review)
    {
        // Logikanya sederhana: balik nilainya. Jika true jadi false, jika false jadi true.
        $review->is_visible = !$review->is_visible;
        $review->save();

        $status = $review->is_visible ? 'ditampilkan' : 'disembunyikan';

        return redirect()->back()->with('success', "Ulasan berhasil {$status}.");
    }

    /**
     * Menghapus ulasan dari database secara permanen.
     */
    public function destroy(Review $review)
    {
        // Hapus foto dari storage jika ada, sebelum menghapus record
        if ($review->photo) {
            Storage::disk('public')->delete($review->photo);
        }

        $review->delete();

        return redirect()->route('admin.reviews.index')
                         ->with('success', 'Ulasan berhasil dihapus secara permanen.');
    }
}

