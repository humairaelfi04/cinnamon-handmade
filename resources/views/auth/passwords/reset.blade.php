@extends('layouts.app')
    @section('title', 'Reset Password')
    @section('content')
    <div class="auth-card">
        <h3>Reset Password</h3>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password-confirm">Konfirmasi Password Baru</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-detail" style="width:100%;">Reset Password</button>
            </div>
        </form>
    </div>
    @endsection

