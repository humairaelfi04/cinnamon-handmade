@extends('admin.layouts.app')
@section('title', 'Kelola Opsi Kustom')
@section('content')
    <div class="page-header">
        <h1>Kelola Opsi Kustom</h1>
        <a href="{{ route('admin.custom-options.create') }}" class="btn btn-primary">Tambah Opsi</a>
    </div>
    @if (session('success'))
        <div class="alert alert-success" style="padding: 15px; background-color: #d4edda; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Opsi</th>
                <th>Harga Tambahan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customOptions as $option)
                <tr>
                    <td>{{ $option->id }}</td>
                    <td><strong>{{ $option->name }}</strong></td>
                    <td>Rp {{ number_format($option->price, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('admin.custom-options.edit', $option->id) }}" class="btn btn-warning" style="color: #3D3B30;">Edit</a>
                        <form action="{{ route('admin.custom-options.destroy', $option->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin hapus opsi ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px;">Belum ada opsi kustom.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
