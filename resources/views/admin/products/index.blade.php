@extends('admin.layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <div class="page-header">
        <h1>Daftar Produk</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Tambah Produk Baru</a>
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
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th> <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="80" style="border-radius: 6px;">
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>

                        <td>{{ $product->category->name ?? 'Tidak ada kategori' }}</td>

                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning" style="color: #3D3B30;">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">Belum ada produk yang ditambahkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $products->links() }}
    </div>
@endsection
