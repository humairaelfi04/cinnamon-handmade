@extends('admin.layouts.app')

@section('title', 'Kelola Bahan Baku')

@section('content')
    <div class="page-header">
        <h1>Kelola Bahan Baku</h1>
        {{-- Mengambil struktur tombol dari kodemu --}}
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.reports.raw-materials.pdf') }}" class="btn" style="background-color: #27ae60;">Cetak PDF</a>
            <a href="{{ route('admin.raw-materials.create') }}" class="btn btn-primary">Tambah Bahan Baku</a>
        </div>
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
                    <th style="width: 80px;">Gambar</th> {{-- <-- KOLOM BARU --}}
                    <th>Nama Bahan</th>
                    <th>Harga</th> {{-- <-- KOLOM BARU --}}
                    <th>Tipe</th> {{-- <-- KOLOM BARU --}}
                    <th>Stok</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rawMaterials as $material)
                    <tr>
                        <td>{{ $material->id }}</td>
                        <td>
                            {{-- Menampilkan gambar komponen --}}
                            @if($material->image)
                                <img src="{{ asset('storage/' . $material->image) }}" alt="{{ $material->name }}" style="width: 60px; height: 60px; border-radius: 6px; object-fit: cover;">
                            @else
                                <div style="width: 60px; height: 60px; background-color: #f0f0f0; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: #999;">No Img</div>
                            @endif
                        </td>
                        <td>
                            {{-- Menampilkan nama & jenis aksesoris --}}
                            <strong>{{ $material->name }}</strong><br>
                            <small style="color: #6c757d;">{{ $material->accessory_type ?: 'Semua Jenis' }}</small>
                        </td>
                        {{-- Menampilkan harga --}}
                        <td>Rp {{ number_format($material->price, 0, ',', '.') }}</td>
                        {{-- Menampilkan tipe bahan --}}
                        <td>{{ $material->material_type }}</td>
                        <td>{{ $material->stock }} {{ $material->satuan }}</td>
                        <td>
                            {{-- Menggunakan gaya tombol dari kodemu --}}
                            <div style="display: flex; gap: 5px;">
                                <a href="{{ route('admin.raw-materials.edit', $material->id) }}" class="btn btn-warning" style="padding: 8px 12px; font-size: 0.8rem; color: white;">Edit</a>
                                <form action="{{ route('admin.raw-materials.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bahan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 8px 12px; font-size: 0.8rem;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Belum ada data bahan baku. Silakan tambahkan terlebih dahulu.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Link Paginasi --}}
    <div style="margin-top: 20px;">
        {{ $rawMaterials->links() }}
    </div>
@endsection
