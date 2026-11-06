@extends('layouts.dashboard')
@section('title','My Profile')
@section('page_title','My Profile')
@section('breadcrumb')<a href="{{ route('faculty.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Profile</span>@endsection
@section('sidebar')@include('faculty.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">My Profile</h1><p style="color:var(--text-muted);font-size:.875rem">Manage your personal information</p></div>
</div>

<div class="row g-4">
    <div class="col-lg-4 animate-slide-up anim-delay-1">
        <div class="dashboard-card text-center">
            <div class="card-body-sc">
                <img src="{{ auth()->user()->avatar_url }}" style="width:100px;height:100px;border-radius:50%;border:4px solid var(--primary-light);margin-bottom:1rem">
                <h4 style="font-weight:800;font-size:1.1rem;margin-bottom:.25rem">{{ auth()->user()->name }}</h4>
                <div style="font-size:.875rem;color:var(--primary);font-weight:600;margin-bottom:.25rem">{{ $faculty->designation }}</div>
                <div style="font-size:.82rem;color:var(--text-muted);margin-bottom:1rem">{{ $faculty->department->name ?? '' }}</div>
                <div class="d-flex flex-wrap gap-2 justify-content-center mb-3">
                    <span class="sc-badge badge-primary">{{ $faculty->faculty_id }}</span>
                    @if($faculty->qualification)<span class="sc-badge badge-secondary">{{ $faculty->qualification }}</span>@endif
                </div>
                <div style="text-align:left;border-top:1px solid var(--border);padding-top:1rem">
                    @foreach([['bi-envelope','Email', auth()->user()->email],['bi-phone','Phone', auth()->user()->phone ?? 'N/A'],['bi-lightbulb','Specialization', $faculty->specialization ?? 'N/A'],['bi-briefcase','Experience', $faculty->experience ?? 'N/A'],['bi-calendar','Joining Date', $faculty->joining_date ? \Carbon\Carbon::parse($faculty->joining_date)->format('d M Y') : 'N/A']] as [$icon, $label, $value])
                    <div class="d-flex gap-2 mb-2">
                        <i class="bi {{ $icon }}" style="color:var(--primary);font-size:.9rem;margin-top:2px;flex-shrink:0"></i>
                        <div><span style="font-size:.72rem;color:var(--text-muted);display:block">{{ $label }}</span><span style="font-size:.85rem;font-weight:500">{{ $value }}</span></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 animate-slide-up anim-delay-2">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-pencil-square me-2 text-primary-sc"></i>Update Profile</h5></div>
            <div class="card-body-sc">
                <form method="POST" action="{{ route('faculty.profile.update') }}" data-validate>
                    @csrf @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Full Name</label>
                                <input type="text" class="sc-input" value="{{ auth()->user()->name }}" disabled style="background:var(--bg)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Email</label>
                                <input type="email" class="sc-input" value="{{ auth()->user()->email }}" disabled style="background:var(--bg)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Phone Number</label>
                                <input type="text" name="phone" class="sc-input" value="{{ old('phone', auth()->user()->phone) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Specialization</label>
                                <input type="text" name="specialization" class="sc-input" value="{{ old('specialization', $faculty->specialization) }}">
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
