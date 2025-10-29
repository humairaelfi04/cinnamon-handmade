@extends('admin.layouts.app')

@section('title', 'Tambah Kategori Baru')

@section('content')
    <div class="page-header">
        <h1>Tambah Kategori Baru</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn" style="background-color: #6c757d; color: white;">Batal</a>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Kategori</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Kategori</button>
    </form>
@endsection
