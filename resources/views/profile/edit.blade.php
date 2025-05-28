@extends('layouts.dashboard')

@section('content')
<div class="auth-wrapper">
    <div class="profile-container">
        <!-- User Profile Card -->
        <div class="auth-card mb-4">
            <div class="auth-header">
                <h2>{{ __('User Profile') }}</h2>
            </div>
            
            @if (session('status') === 'profile-updated')
                <div class="alert-success" role="alert">
                    {{ __('Profile has been successfully updated.') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="post" action="{{ route('profile.update') }}" class="profile-form">
                @csrf
                @method('patch')
                
                <div class="form-group">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input id="name" name="name" type="text" class="form-input @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                    @error('name')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" name="email" type="email" class="form-input @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
                    @error('email')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="verification-alert">
                            {{ __('Your email address is not verified.') }}

                            <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-link">
                                    {{ __('Click here to resend verification email.') }}
                                </button>
                            </form>
                        </div>

                        @if (session('status') === 'verification-link-sent')
                            <div class="verification-success">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </div>
                        @endif
                    @endif
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">
                        {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Delete Account Card -->
        <div class="auth-card danger-card">
            <div class="auth-header danger-header">
                <h2>{{ __('Delete Account') }}</h2>
            </div>
            
            <p class="danger-text">
                {{ __('After your account is deleted, all its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you want to keep.') }}
            </p>

            <!-- Delete button removed as requested -->

            <!-- Delete Account Confirmation Modal -->
            <div class="modal fade" id="confirmDeletion" tabindex="-1" aria-labelledby="confirmDeletionLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form method="post" action="{{ route('profile.destroy') }}" class="modal-content glass-modal">
                        @csrf
                        @method('delete')
                        
                        <div class="modal-header">
                            <h5 class="modal-title text-white" id="confirmDeletionLabel">{{ __('Are you sure you want to delete your account?') }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body" style="background: rgba(0, 0, 0, 0.7); border-radius: 8px;">
                            <div class="form-group">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" name="password" type="password" class="form-input @error('password', 'userDeletion') is-invalid @enderror" placeholder="{{ __('Password') }}" required style="background: rgba(0, 0, 0, 0.5); border: 1px solid rgba(255, 255, 255, 0.2);">
                                
                                @error('password', 'userDeletion')
                                    <div class="form-error">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Main background */
    body {
        background: linear-gradient(135deg, #70c4e8 0%, #4a9ad7 100%);
        min-height: 100vh;
        font-family: 'Figtree', sans-serif;
        color: #fff;
    }
    
    /* Auth wrapper - similar to login page */
    .auth-wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem 1rem;
    }
    
    /* Profile container */
    .profile-container {
        max-width: 500px;
        width: 100%;
    }
    
    /* Auth card - similar to login page */
    .auth-card {
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 15px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        padding: 2rem;
        width: 100%;
        margin: 0 auto;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    /* Danger card variation */
    .danger-card {
        background: rgba(0, 0, 0, 0.7);
    }
    
    /* Header styling */
    .auth-header {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #fff;
    }
    
    .danger-header h2 {
        color: #f87171;
    }
    
    /* Form styling */
    .profile-form {
        width: 100%;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
        display: block;
        margin-bottom: 0.5rem;
    }
    
    /* Form inputs */
    .form-input {
        background: rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 5px;
        padding: 0.5rem 1rem;
        width: 100%;
    }
    
    .form-input:focus {
        outline: none;
        border-color: rgba(255, 255, 255, 0.5);
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.2);
    }
    
    .form-input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }
    
    /* Button styling */
    .btn {
        background: rgba(59, 130, 246, 0.8);
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 5px;
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .btn:hover {
        background: rgba(37, 99, 235, 0.9);
        transform: translateY(-2px);
    }
    
    .btn-danger {
        background: rgba(229, 57, 53, 0.8);
    }
    
    .btn-danger:hover {
        background: rgba(229, 57, 53, 0.9);
    }
    
    .btn-secondary {
        background: rgba(100, 100, 100, 0.8);
    }
    
    .btn-secondary:hover {
        background: rgba(100, 100, 100, 0.9);
    }
    
    .btn-link {
        background: transparent;
        color: rgba(59, 130, 246, 0.9);
        text-decoration: none;
        font-weight: 500;
        padding: 0;
        border: none;
        cursor: pointer;
    }
    
    .btn-link:hover {
        text-decoration: underline;
    }
    
    /* Form actions */
    .form-actions {
        margin-top: 1.5rem;
        text-align: center;
    }
    
    /* Alert styling */
    .alert-success {
        background-color: rgba(40, 167, 69, 0.15);
        border: 1px solid rgba(40, 167, 69, 0.2);
        color: #28a745;
        padding: 0.75rem;
        border-radius: 5px;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .form-error {
        color: #f87171;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    .verification-alert {
        color: #ffc107;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    .verification-success {
        color: #28a745;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    /* Danger text */
    .danger-text {
        color: rgba(255, 255, 255, 0.7);
        text-align: center;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }
    
    /* Modal styling */
    .glass-modal {
        background-color: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: #fff;
    }
    
    .modal-header, .modal-footer {
        border: none;
        background-color: transparent;
    }
    
    .modal-text {
        color: rgba(255, 255, 255, 0.7);
    }
    
    .modal-title {
        color: #fff;
    }
    
    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .profile-container {
            max-width: 100%;
        }
    }
</style>
@endsection