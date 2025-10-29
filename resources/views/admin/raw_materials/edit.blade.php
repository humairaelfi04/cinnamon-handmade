@extends('admin.layouts.app')

@section('title', 'Edit Bahan Baku')

@section('content')
    <div class="page-header">
        <h1>Edit Bahan Baku: {{ $rawMaterial->name }}</h1>
        <a href="{{ route('admin.raw-materials.index') }}" class="btn" style="background-color: #6c757d; color: white;">Batal</a>
    </div>

    <form action="{{ route('admin.raw-materials.update', $rawMaterial->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        {{-- PERBAIKAN: Menggunakan underscore agar sesuai nama folder --}}
        @include('admin.raw_materials._form', ['buttonText' => 'Update Bahan Baku'])
    </form>
@endsection
