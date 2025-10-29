@extends('admin.layouts.app')
@section('title', 'Edit Opsi Kustom')
@section('content')
    <div class="page-header">
        <h1>Edit Opsi: {{ $customOption->name }}</h1>
        <a href="{{ route('admin.custom-options.index') }}" class="btn" style="background-color: #6c757d; color: white;">Batal</a>
    </div>
    <form action="{{ route('admin.custom-options.update', $customOption->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Opsi</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $customOption->name) }}" required>
        </div>
        <div class="form-group">
            <label for="price">Harga Tambahan</label>
            <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $customOption->price) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Opsi</button>
    </form>
@endsection
