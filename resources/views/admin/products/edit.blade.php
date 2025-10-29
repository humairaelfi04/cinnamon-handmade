@extends('admin.layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <div class="page-header">
        <h1>Edit Produk: {{ $product->name }}</h1>
        <a href="{{ route('admin.products.index') }}" class="btn" style="background-color: #6c757d; color: white;">Batal</a>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Memanggil semua input form dari file partial --}}
        @include('admin.products._form')

        <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Update Produk</button>
    </form>
@endsection
