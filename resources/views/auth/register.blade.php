@extends('layouts.auth')
@section('title','Register')
@section('content')
<div>
    <div class="auth-title">Apply for Admission</div>
    <div class="auth-subtitle">Create your student account to get started</div>

    <form method="POST" action="{{ route('register') }}" data-validate>
        @csrf
        <div class="row g-2">
            <div class="col-12">
                <div class="sc-form-group">
                    <label class="sc-label">Full Name *</label>
                    <div style="position:relative"><i class="bi bi-person" style="position:absolute;left:.875rem;top:50%;transform:translateY(-50%);color:var(--text-muted)"></i>
                    <input type="text" name="name" class="sc-input {{ $errors->has('name')?'is-invalid':'' }}" placeholder="Your full name" value="{{ old('name') }}" style="padding-left:2.6rem" required></div>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="sc-form-group">
                    <label class="sc-label">Email Address *</label>
                    <input type="email" name="email" class="sc-input {{ $errors->has('email')?'is-invalid':'' }}" placeholder="student@email.com" value="{{ old('email') }}" required>
                    @error('email')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="sc-form-group">
                    <label class="sc-label">Phone Number *</label>
                    <input type="text" name="phone" class="sc-input {{ $errors->has('phone')?'is-invalid':'' }}" placeholder="10-digit phone" value="{{ old('phone') }}" required>
                </div>
            </div>
            <div class="col-12">
                <div class="sc-form-group">
                    <label class="sc-label">Select Course *</label>
                    <select name="course_id" class="sc-select {{ $errors->has('course_id')?'is-invalid':'' }}" required>
                        <option value="">Choose your course</option>
                        @foreach($courses->groupBy('department.name') as $dept => $deptCourses)
                        <optgroup label="{{ $dept }}">
                            @foreach($deptCourses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id')==$course->id?'selected':'' }}>{{ $course->name }} ({{ $course->duration_years }} yr)</option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                    @error('course_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="sc-form-group">
                    <label class="sc-label">Password *</label>
                    <input type="password" name="password" class="sc-input {{ $errors->has('password')?'is-invalid':'' }}" placeholder="Min. 8 characters" required>
                    @error('password')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="sc-form-group">
                    <label class="sc-label">Confirm Password *</label>
                    <input type="password" name="password_confirmation" class="sc-input" placeholder="Repeat password" required>
                </div>
            </div>
        </div>
        <div style="background:rgba(49,87,213,.06);border:1px solid rgba(49,87,213,.15);border-radius:10px;padding:.875rem;margin-bottom:1rem;font-size:.8rem;color:var(--text-muted)">
            <i class="bi bi-info-circle text-primary-sc me-1"></i> By registering you agree to our <a href="#" style="color:var(--primary)">Terms of Service</a> and <a href="#" style="color:var(--primary)">Privacy Policy</a>.
        </div>
        <button type="submit" class="btn-primary-sc w-100" style="padding:.85rem;font-weight:700">
            <i class="bi bi-person-plus me-2"></i>Create Account
        </button>
    </form>

    <div class="auth-divider"><span>Already have an account?</span></div>
    <a href="{{ route('login') }}" class="btn-outline-sc w-100" style="text-align:center;padding:.75rem">
        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
    </a>
    <div class="mt-3 text-center"><a href="{{ route('home') }}" style="font-size:.78rem;color:var(--text-muted)"><i class="bi bi-arrow-left me-1"></i>Back to Website</a></div>
</div>
@endsection
