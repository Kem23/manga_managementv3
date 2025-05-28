@extends('layouts.guest')

@section('content')
    <div class="auth-header">
        <h2>LOGIN</h2>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div>
            <label for="email" class="form-label">Enter your email</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password" class="form-label">Enter your Password</label>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" />
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="checkbox-container">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Remember me</label>
        </div>

        <button type="submit" class="btn">LOGIN</button>
        
        <div class="auth-footer">
            @if (Route::has('password.request'))
                <a class="btn-link" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif
            
            <p>No Account? <a class="btn-link" href="{{ route('register') }}">Create Account!</a></p>
        </div>
    </form>
@endsection