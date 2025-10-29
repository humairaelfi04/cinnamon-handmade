@extends('admin.layouts.app')

@section('title', 'Edit Tag')

@section('content')
    <div class="page-header">
        <h1>Edit Tag: {{ $tag->name }}</h1>
        <a href="{{ route('admin.tags.index') }}" class="btn" style="background-color: #6c757d; color: white;">Batal</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="padding: 15px; background-color: #f8d7da; color: #721c24; margin-bottom: 20px; border-radius: 6px;">
            <strong>Oops! Ada beberapa masalah:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Tag</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $tag->name) }}" required>
        </div>

        <div class="form-group">
            <label for="type">Tipe Filter</label>
            <select name="type" id="type" class="form-control" required>
                <option value="Gaya" @if(old('type', $tag->type) == 'Gaya') selected @endif>Gaya (cth: Bohemian, Klasik)</option>
                <option value="Energi" @if(old('type', $tag->type) == 'Energi') selected @endif>Makna & Energi (cth: Ketenangan)</option>
                <option value="Batu" @if(old('type', $tag->type) == 'Batu') selected @endif>Jenis Batu Alam (cth: Kuarsa Mawar)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Tag</button>
    </form>
@endsection
