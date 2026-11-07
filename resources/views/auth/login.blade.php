@extends('layouts.auth')
@section('title','Login')
@section('content')
<div>
    <div class="auth-title">Welcome Back! 👋</div>
    <div class="auth-subtitle">Sign in to your SMART CAMPUS account</div>

    @if(session('success'))
    <div class="sc-alert success mb-3 animate-fade-down"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="sc-alert danger mb-3 animate-fade-down"><i class="bi bi-x-circle-fill"></i> {{ session('error') }}</div>
    @endif

    <!-- Demo Credentials -->
    <div style="background:var(--gradient-1);border-radius:12px;padding:1rem;margin-bottom:1.5rem">
        <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:rgba(255,255,255,.75);margin-bottom:.6rem">🔑 Demo Credentials</div>
        <div class="d-flex flex-wrap gap-2">
            <button onclick="fillLogin('admin@smartcampus.edu','password')" style="background:rgba(255,255,255,.2);border:1px solid rgba(255,255,255,.3);color:white;padding:.3rem .75rem;border-radius:6px;font-size:.72rem;cursor:pointer;transition:all .2s" onmouseover="this.style.background='rgba(255,255,255,.3)'" onmouseout="this.style.background='rgba(255,255,255,.2)'"><i class="bi bi-shield-lock me-1"></i>Admin</button>
            <button onclick="fillLogin('faculty1@smartcampus.edu','password')" style="background:rgba(255,255,255,.2);border:1px solid rgba(255,255,255,.3);color:white;padding:.3rem .75rem;border-radius:6px;font-size:.72rem;cursor:pointer;transition:all .2s" onmouseover="this.style.background='rgba(255,255,255,.3)'" onmouseout="this.style.background='rgba(255,255,255,.2)'"><i class="bi bi-person-badge me-1"></i>Faculty</button>
            <button onclick="fillLogin('student1@smartcampus.edu','password')" style="background:rgba(255,255,255,.2);border:1px solid rgba(255,255,255,.3);color:white;padding:.3rem .75rem;border-radius:6px;font-size:.72rem;cursor:pointer;transition:all .2s" onmouseover="this.style.background='rgba(255,255,255,.3)'" onmouseout="this.style.background='rgba(255,255,255,.2)'"><i class="bi bi-mortarboard me-1"></i>Student</button>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" data-validate>
        @csrf
        <div class="sc-form-group">
            <label class="sc-label">Email Address</label>
            <div style="position:relative">
                <i class="bi bi-envelope" style="position:absolute;left:.875rem;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:.9rem"></i>
                <input type="email" id="email" name="email" class="sc-input {{ $errors->has('email')?'is-invalid':'' }}" placeholder="Enter your email" value="{{ old('email') }}" style="padding-left:2.6rem" required autofocus>
            </div>
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="sc-form-group">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label class="sc-label mb-0">Password</label>
                <a href="{{ route('password.request') }}" style="font-size:.78rem;color:var(--primary);font-weight:600">Forgot password?</a>
            </div>
            <div style="position:relative">
                <i class="bi bi-lock" style="position:absolute;left:.875rem;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:.9rem"></i>
                <input type="password" id="password" name="password" class="sc-input {{ $errors->has('password')?'is-invalid':'' }}" placeholder="Enter your password" style="padding-left:2.6rem;padding-right:3rem" required>
                <button type="button" onclick="togglePwd()" style="position:absolute;right:.875rem;top:50%;transform:translateY(-50%);border:none;background:none;color:var(--text-muted);cursor:pointer;font-size:.9rem" id="eyeBtn"><i class="bi bi-eye" id="eyeIcon"></i></button>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.85rem;color:var(--text)">
                <input type="checkbox" name="remember" style="width:16px;height:16px;accent-color:var(--primary)">
                Remember me
            </label>
        </div>
        <button type="submit" class="btn-primary-sc w-100" style="padding:.85rem;font-size:.95rem;font-weight:700">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>
    </form>

    <div class="auth-divider"><span>New to SMART CAMPUS?</span></div>
    <a href="{{ route('register') }}" class="btn-outline-sc w-100" style="text-align:center;padding:.75rem">
        <i class="bi bi-person-plus me-2"></i>Apply for Admission
    </a>

    <div class="mt-4 text-center" style="font-size:.75rem;color:var(--text-muted)">
        <a href="{{ route('home') }}" style="color:var(--text-muted)"><i class="bi bi-arrow-left me-1"></i>Back to Website</a>
    </div>
</div>
@endsection
@push('scripts')
<script>
function fillLogin(e,p){ document.getElementById('email').value=e; document.getElementById('password').value=p; }
function togglePwd(){
    const inp=document.getElementById('password');
    const ic=document.getElementById('eyeIcon');
    if(inp.type==='password'){ inp.type='text'; ic.className='bi bi-eye-slash'; }
    else { inp.type='password'; ic.className='bi bi-eye'; }
}
</script>
@endpush
