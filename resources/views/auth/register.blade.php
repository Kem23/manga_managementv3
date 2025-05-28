@extends('layouts.guest')

@section('content')
    <div class="auth-header">
        <h2>Register a New Account!</h2>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name" class="form-label">What should we call you?</label>
            <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            @error('name')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email" class="form-label">Your email (for important updates!)</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password" class="form-label">Create a password</label>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" />
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="form-label">Repeat your password</label>
            <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" />
            @error('password_confirmation')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn">SIGN UP</button>
        
        <div class="auth-footer">
            <a class="btn-link" href="{{ route('login') }}">Already registered?</a>
        </div>
    </form>
@endsection