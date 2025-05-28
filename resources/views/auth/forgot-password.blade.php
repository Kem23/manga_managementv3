@extends('layouts.guest')

@section('content')
    <div class="auth-header">
        <h2>Forgot Password</h2>
    </div>

    <div class="mb-4 text-sm text-white">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-400">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus />
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn">
            {{ __('Email Password Reset Link') }}
        </button>
        
        <div class="auth-footer">
            <a class="btn-link" href="{{ route('login') }}">Back to Login</a>
        </div>
    </form>
@endsection