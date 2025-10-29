@extends('admin.layouts.app')

@section('title', 'Tambah Tag Baru')

@section('content')
    <div class="page-header">
        <h1>Tambah Tag Baru</h1>
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

    <form action="{{ route('admin.tags.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Tag</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Bohemian, Ketenangan, Kuarsa Mawar">
        </div>

        <div class="form-group">
            <label for="type">Tipe Filter</label>
            <select name="type" id="type" class="form-control" required>
                <option value="" disabled selected>-- Pilih Tipe --</option>
                <option value="Gaya" @if(old('type') == 'Gaya') selected @endif>Gaya (cth: Bohemian, Klasik)</option>
                <option value="Energi" @if(old('type') == 'Energi') selected @endif>Makna & Energi (cth: Ketenangan)</option>
                <option value="Batu" @if(old('type') == 'Batu') selected @endif>Jenis Batu Alam (cth: Kuarsa Mawar)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Tag</button>
    </form>
@endsection
