@extends('layouts.app')

@section('title', 'Login ke Akun Anda')

@push('styles')
<style>
    .auth-container { display: flex; justify-content: center; align-items: center; padding: 50px 0; }
    .auth-card { background-color: var(--white-card); padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; max-width: 450px; }
    .auth-card h1 { font-family: 'Playfair Display', serif; text-align: center; margin-top: 0; margin-bottom: 30px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
    .form-control { width: 100%; padding: 12px 15px; border: 1px solid var(--light-border); border-radius: 6px; font-family: 'Montserrat', sans-serif; box-sizing: border-box; }
    .btn-auth { width: 100%; padding: 12px; border: none; border-radius: 6px; background-color: var(--primary-brown); color: white; font-weight: 700; font-size: 1rem; cursor: pointer; transition: background-color 0.3s; }
    .btn-auth:hover { background-color: var(--hover-brown); }
    .auth-switch-link { text-align: center; margin-top: 20px; }
    .auth-switch-link a { color: var(--primary-brown); font-weight: 500; text-decoration: none; }

    /* === STYLE UNTUK KOTAK PESAN ERROR === */
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        border: 1px solid #f5c6cb;
    }
    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }
</style>
@endpush

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1>Login</h1>

        {{-- Menampilkan error dari session (seperti "Anda harus login...") --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Menampilkan error validasi (seperti "Email wajib diisi") --}}
        @if ($errors->any())
            <div class="alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-detail" style="width:100%;">Login</button>
            <div style="text-align: center; margin-top: 15px;">
                <a href="{{ route('password.request') }}" style="font-size: 0.9rem; color: var(--primary-brown);">
                Lupa Password?
                </a>
        </form>

        <div class="auth-switch-link">
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
        </div>
    </div>
</div>
@endsection
