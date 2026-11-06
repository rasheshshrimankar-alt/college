@extends('layouts.auth')
@section('title','Reset Password')
@section('content')
<div>
    <div style="font-size:3rem;margin-bottom:1rem">🔑</div>
    <div class="auth-title">Reset Password</div>
    <div class="auth-subtitle">Enter your new password below.</div>

    <form method="POST" action="{{ route('password.update') }}" data-validate>
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="sc-form-group">
            <label class="sc-label">Email Address</label>
            <input type="email" name="email" class="sc-input {{ $errors->has('email')?'is-invalid':'' }}"
                value="{{ old('email', $email ?? '') }}" required autofocus>
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="sc-form-group">
            <label class="sc-label">New Password</label>
            <input type="password" name="password" class="sc-input {{ $errors->has('password')?'is-invalid':'' }}"
                placeholder="Min. 8 characters" required>
            @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="sc-form-group">
            <label class="sc-label">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="sc-input" placeholder="Repeat password" required>
        </div>
        <button type="submit" class="btn-primary-sc w-100" style="padding:.85rem;font-weight:700">
            <i class="bi bi-shield-check me-2"></i>Reset Password
        </button>
    </form>

    <div class="auth-divider"><span>Remember it?</span></div>
    <a href="{{ route('login') }}" class="btn-outline-sc w-100" style="text-align:center;padding:.75rem">
        <i class="bi bi-arrow-left me-2"></i>Back to Login
    </a>
</div>
@endsection
