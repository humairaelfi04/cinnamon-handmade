@extends('admin.layouts.app')
@section('title', 'Tambah Opsi Kustom')
@section('content')
    <div class="page-header">
        <h1>Tambah Opsi Kustom Baru</h1>
        <a href="{{ route('admin.custom-options.index') }}" class="btn" style="background-color: #6c757d; color: white;">Batal</a>
    </div>
    <form action="{{ route('admin.custom-options.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Opsi</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Ukir Nama Inisial">
        </div>
        <div class="form-group">
            <label for="price">Harga Tambahan</label>
            <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Opsi</button>
    </form>
@endsection
