@extends('admin.layouts.app')

@section('title', 'Kelola Tag Filter')

@section('content')
    <div class="page-header">
        <h1>Kelola Tag Filter</h1>
        <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">Tambah Tag Baru</a>
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
                    <th>ID</th>
                    <th>Nama Tag</th>
                    <th>Tipe Filter</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tags as $tag)
                    <tr>
                        <td>{{ $tag->id }}</td>
                        <td><strong>{{ $tag->name }}</strong></td>
                        <td>{{ $tag->type }}</td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <a href="{{ route('admin.tags.edit', $tag->id) }}" class="btn btn-warning" style="padding: 8px 12px; font-size: 0.8rem; color: white;">Edit</a>
                                <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tag ini? Menghapus tag akan melepaskannya dari semua produk terkait.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 8px 12px; font-size: 0.8rem;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Belum ada tag yang dibuat. Silakan tambahkan tag baru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Link Paginasi --}}
    <div style="margin-top: 20px;">
        {{ $tags->links() }}
    </div>
@endsection
