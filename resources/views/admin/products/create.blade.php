@extends('admin.layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')
    <div class="page-header">
        <h1>Tambah Produk Baru</h1>
        <a href="{{ route('admin.products.index') }}" class="btn" style="background-color: #6c757d; color: white;">Batal</a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Memanggil semua input form dari file partial --}}
        @include('admin.products._form')

        <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Simpan Produk</button>
    </form>
@endsection
