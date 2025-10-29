@extends('admin.layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <div class="page-header">
        <h1>Edit Kategori: {{ $category->name }}</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn" style="background-color: #6c757d; color: white;">Batal</a>
    </div>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Kategori</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary">Update Kategori</button>
    </form>
@endsection
