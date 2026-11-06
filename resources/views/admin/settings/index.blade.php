@extends('layouts.dashboard')
@section('title','Settings')
@section('page_title','Settings')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><span>Settings</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Settings</h1><p style="color:var(--text-muted);font-size:.875rem">Manage your account and system preferences</p></div>
</div>

<div class="row g-4">
    <!-- Profile Settings -->
    <div class="col-lg-8 animate-slide-up anim-delay-1">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-person-gear me-2 text-primary-sc"></i>Account Settings</h5></div>
            <div class="card-body-sc">
                <form method="POST" action="{{ route('admin.settings.update') }}" data-validate>
                    @csrf
                    <div class="text-center mb-4">
                        <img src="{{ $user->avatar_url }}" style="width:90px;height:90px;border-radius:50%;border:4px solid var(--primary-light)">
                        <div style="margin-top:.75rem;font-size:.82rem;color:var(--text-muted)">Profile avatar from UI-Avatars</div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Full Name</label>
                                <input type="text" name="name" class="sc-input" value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Email Address</label>
                                <input type="email" name="email" class="sc-input" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Phone Number</label>
                                <input type="text" name="phone" class="sc-input" value="{{ old('phone', $user->phone) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Role</label>
                                <input type="text" class="sc-input" value="{{ ucfirst($user->role) }}" disabled style="background:var(--bg);cursor:not-allowed">
                            </div>
                        </div>
                        <div class="col-12"><hr style="border-color:var(--border)"></div>
                        <div class="col-12"><h6 style="font-weight:700;color:var(--text-muted);font-size:.82rem;text-transform:uppercase;letter-spacing:.5px">Change Password (leave blank to keep current)</h6></div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">New Password</label>
                                <input type="password" name="password" class="sc-input" placeholder="Enter new password (min 8 chars)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="sc-input" placeholder="Confirm new password">
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Save Changes</button>
                        <button type="reset" class="btn-outline-sc"><i class="bi bi-arrow-counterclockwise me-2"></i>Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- System Stats -->
    <div class="col-lg-4 animate-slide-up anim-delay-2">
        <div class="dashboard-card mb-4">
            <div class="card-header-sc"><h5><i class="bi bi-info-circle me-2 text-primary-sc"></i>System Info</h5></div>
            <div class="card-body-sc">
                @foreach([['Laravel Version', app()->version(), 'bi-gear'],['PHP Version', PHP_VERSION, 'bi-code-slash'],['Environment', config('app.env'), 'bi-cloud'],['Debug Mode', config('app.debug')?'Enabled':'Disabled', 'bi-bug']] as [$label, $val, $icon])
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom:1px solid var(--border)">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi {{ $icon }}" style="color:var(--primary);font-size:1rem"></i>
                        <span style="font-size:.85rem;color:var(--text-muted)">{{ $label }}</span>
                    </div>
                    <span style="font-size:.85rem;font-weight:600">{{ $val }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-database me-2 text-primary-sc"></i>Database Stats</h5></div>
            <div class="card-body-sc">
                @foreach([['Students', $stats['students'], 'bi-people', 'blue'],['Faculty', $stats['faculty'], 'bi-person-badge', 'purple'],['Courses', $stats['courses'], 'bi-book', 'green'],['Departments', $stats['departments'], 'bi-building', 'orange']] as [$label, $count, $icon, $color])
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:32px;height:32px;border-radius:8px;background:rgba(49,87,213,.1);display:flex;align-items:center;justify-content:center"><i class="bi {{ $icon }}" style="color:var(--primary);font-size:.85rem"></i></div>
                        <span style="font-size:.85rem">{{ $label }}</span>
                    </div>
                    <span style="font-size:1rem;font-weight:800;color:var(--primary)">{{ number_format($count) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
