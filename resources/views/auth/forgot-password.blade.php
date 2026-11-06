@extends('layouts.auth')
@section('title','Forgot Password')
@section('content')
<div>
    <div style="font-size:3rem;margin-bottom:1rem">🔐</div>
    <div class="auth-title">Forgot Password?</div>
    <div class="auth-subtitle">Enter your email and we'll send you a reset link.</div>
    @if(session('success'))
    <div class="sc-alert success mb-3"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('password.email') }}" data-validate>
        @csrf
        <div class="sc-form-group">
            <label class="sc-label">Email Address</label>
            <div style="position:relative"><i class="bi bi-envelope" style="position:absolute;left:.875rem;top:50%;transform:translateY(-50%);color:var(--text-muted)"></i>
            <input type="email" name="email" class="sc-input {{ $errors->has('email')?'is-invalid':'' }}" placeholder="your@email.com" value="{{ old('email') }}" style="padding-left:2.6rem" required autofocus>
            @error('email')<div class="form-error">{{ $message }}</div>@enderror</div>
        </div>
        <button type="submit" class="btn-primary-sc w-100" style="padding:.85rem;font-weight:700"><i class="bi bi-send me-2"></i>Send Reset Link</button>
    </form>
    <div class="auth-divider"><span>Remember it?</span></div>
    <a href="{{ route('login') }}" class="btn-outline-sc w-100" style="text-align:center;padding:.75rem"><i class="bi bi-arrow-left me-2"></i>Back to Login</a>
</div>
@endsection
