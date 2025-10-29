@extends('admin.layouts.app')

@section('title', 'Kelola Ulasan Pelanggan')

@section('content')
    <div class="page-header">
        <h1>Kelola Ulasan Pelanggan</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="padding: 15px; background-color: #d4edda; margin-bottom: 20px; border-radius: 6px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 15%;">Pelanggan</th>
                    <th style="width: 20%;">Produk</th>
                    <th style="width: 35%;">Ulasan</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reviews as $review)
                    {{-- Memberi warna latar berbeda jika ulasan disembunyikan --}}
                    <tr style="{{ !$review->is_visible ? 'background-color: #f8d7da;' : '' }}">
                        <td>{{ $review->user->name }}</td>
                        <td>
                            <a href="{{ route('products.show', $review->product_id) }}" target="_blank">
                                {{ $review->product->name }}
                            </a>
                        </td>
                        <td>
                            <div style="display: flex; gap: 15px; align-items: flex-start;">
                                @if($review->photo)
                                    <a href="{{ asset('storage/' . $review->photo) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $review->photo) }}" alt="Foto Ulasan" style="width: 80px; height: 80px; object-fit: cover; border-radius: 6px;">
                                    </a>
                                @endif
                                <div>
                                    <div style="color: #f5b301; font-size: 1.1rem; margin-bottom: 5px;">
                                        @for ($i = 1; $i <= 5; $i++)
                                            {!! $i <= $review->rating ? '★' : '☆' !!}
                                        @endfor
                                    </div>
                                    <p style="margin: 0; font-size: 0.9rem;">{{ $review->comment ?: 'Tidak ada komentar.' }}</p>
                                    <small style="color: #6c757d;">{{ $review->created_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($review->is_visible)
                                <span style="background-color: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Ditampilkan</span>
                            @else
                                <span style="background-color: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Disembunyikan</span>
                            @endif
                        </td>
                        <td>
                            {{-- Tombol untuk Sembunyikan/Tampilkan --}}
                            <form action="{{ route('admin.reviews.toggleVisibility', $review->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                <button type="submit" class="btn" style="background-color: {{ $review->is_visible ? '#ffc107' : '#28a745' }}; color: white; padding: 8px 12px; font-size: 0.8rem;">
                                    {{ $review->is_visible ? 'Sembunyikan' : 'Tampilkan' }}
                                </button>
                            </form>

                            {{-- Tombol untuk Hapus Permanen --}}
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 8px 12px; font-size: 0.8rem;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">Belum ada ulasan dari pelanggan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Link Paginasi --}}
    <div style="margin-top: 20px;">
        {{ $reviews->links() }}
    </div>
@endsection
