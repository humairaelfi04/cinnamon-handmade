@extends('admin.layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
    <div class="page-header">
        <h1>Kelola Kategori Produk</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Tambah Kategori</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="padding: 15px; background-color: #d4edda; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td>{{ $category->products_count }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning" style="color: #3D3B30;">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin hapus kategori ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px;">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
