@extends('layouts.app')

@section('title', 'Buat Akun Baru')

@push('styles')
<style>
    .auth-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 50px 0;
    }
    .auth-card {
        background-color: var(--white-card);
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        width: 100%;
        max-width: 450px;
    }
    .auth-card h1 {
        font-family: 'Playfair Display', serif;
        text-align: center;
        margin-top: 0;
        margin-bottom: 30px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--light-border);
        border-radius: 6px;
        font-family: 'Montserrat', sans-serif;
        box-sizing: border-box;
    }
    .btn-auth {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 6px;
        background-color: var(--primary-brown);
        color: white;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .btn-auth:hover {
        background-color: var(--hover-brown);
    }
    .auth-switch-link {
        text-align: center;
        margin-top: 20px;
    }
    .auth-switch-link a {
        color: var(--primary-brown);
        font-weight: 500;
        text-decoration: none;
    }
    .auth-errors {
        background-color: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1>Register</h1>

        @if ($errors->any())
            <div class="auth-errors">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn-auth">Register</button>
        </form>

        <div class="auth-switch-link">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
        </div>
    </div>
</div>
@endsection
