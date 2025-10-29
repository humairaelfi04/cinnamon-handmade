    @extends('layouts.app')
    @section('title', 'Lupa Password')
    @section('content')
    <div class="auth-card">
        <h3>Lupa Password</h3>
        <p>Masukkan alamat email Anda dan kami akan mengirimkan link untuk mereset password Anda.</p>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-detail" style="width:100%;">Kirim Link Reset Password</button>
            </div>
        </form>
    </div>
    @endsection
