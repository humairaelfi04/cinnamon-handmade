@extends('admin.layouts.app')

@section('title', 'Tambah Bahan Baku')

@section('content')
    <div class="page-header">
        <h1>Tambah Bahan Baku Baru</h1>
        <a href="{{ route('admin.raw-materials.index') }}" class="btn" style="background-color: #6c757d; color: white;">Batal</a>
    </div>

    <form action="{{ route('admin.raw-materials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- PERBAIKAN: Menggunakan underscore agar sesuai nama folder --}}
        @include('admin.raw_materials._form', ['buttonText' => 'Tambah Bahan Baku'])
    </form>
@endsection
