@extends('layouts.dashboard')
@section('title','Admin Dashboard')
@section('page_title','Dashboard')
@section('breadcrumb')<span>Dashboard</span>@endsection

@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i><span class="item-text">Dashboard</span></a>
<a href="{{ route('admin.students.index') }}" class="sidebar-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}"><i class="bi bi-people"></i><span class="item-text">Students</span></a>
<a href="{{ route('admin.faculty.index') }}" class="sidebar-item {{ request()->routeIs('admin.faculty.*') ? 'active' : '' }}"><i class="bi bi-person-badge"></i><span class="item-text">Faculty</span></a>
<a href="{{ route('admin.departments.index') }}" class="sidebar-item {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}"><i class="bi bi-building"></i><span class="item-text">Departments</span></a>
<a href="{{ route('admin.courses.index') }}" class="sidebar-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}"><i class="bi bi-book"></i><span class="item-text">Courses</span></a>
<a href="{{ route('admin.admissions.index') }}" class="sidebar-item {{ request()->routeIs('admin.admissions.*') ? 'active' : '' }}"><i class="bi bi-person-plus"></i><span class="item-text">Admissions</span><span class="item-badge">{{ $stats['pending_admissions'] }}</span></a>
<a href="{{ route('admin.examinations.index') }}" class="sidebar-item {{ request()->routeIs('admin.examinations.*') ? 'active' : '' }}"><i class="bi bi-clipboard2-check"></i><span class="item-text">Examinations</span></a>
<a href="{{ route('admin.results.index') }}" class="sidebar-item {{ request()->routeIs('admin.results.*') ? 'active' : '' }}"><i class="bi bi-graph-up"></i><span class="item-text">Results</span></a>
<a href="{{ route('admin.fees.index') }}" class="sidebar-item {{ request()->routeIs('admin.fees.*') ? 'active' : '' }}"><i class="bi bi-cash-stack"></i><span class="item-text">Fees</span></a>
<a href="{{ route('admin.library.index') }}" class="sidebar-item {{ request()->routeIs('admin.library.*') ? 'active' : '' }}"><i class="bi bi-journals"></i><span class="item-text">Library</span></a>
<a href="{{ route('admin.notices.index') }}" class="sidebar-item {{ request()->routeIs('admin.notices.*') ? 'active' : '' }}"><i class="bi bi-megaphone"></i><span class="item-text">Notices</span></a>
<a href="{{ route('admin.news.index') }}" class="sidebar-item {{ request()->routeIs('admin.news.*') ? 'active' : '' }}"><i class="bi bi-newspaper"></i><span class="item-text">News</span></a>
<a href="{{ route('admin.events.index') }}" class="sidebar-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}"><i class="bi bi-calendar-event"></i><span class="item-text">Events</span></a>
<a href="{{ route('admin.gallery.index') }}" class="sidebar-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}"><i class="bi bi-images"></i><span class="item-text">Gallery</span></a>
<a href="{{ route('admin.placements.index') }}" class="sidebar-item {{ request()->routeIs('admin.placements.*') ? 'active' : '' }}"><i class="bi bi-briefcase"></i><span class="item-text">Placements</span></a>
<a href="{{ route('admin.scholarships.index') }}" class="sidebar-item {{ request()->routeIs('admin.scholarships.*') ? 'active' : '' }}"><i class="bi bi-award"></i><span class="item-text">Scholarships</span></a>
<a href="{{ route('admin.complaints.index') }}" class="sidebar-item {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}"><i class="bi bi-chat-left-text"></i><span class="item-text">Complaints</span><span class="item-badge">{{ $stats['open_complaints'] }}</span></a>
<a href="{{ route('admin.reports.index') }}" class="sidebar-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"><i class="bi bi-bar-chart-line"></i><span class="item-text">Reports</span></a>
<a href="{{ route('admin.settings.index') }}" class="sidebar-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"><i class="bi bi-gear"></i><span class="item-text">Settings</span></a>
@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div>
        <h1 class="page-title">Welcome back, {{ Str::limit(auth()->user()->name,20) }}! 👋</h1>
        <p style="color:var(--text-muted);font-size:.875rem;margin:0">{{ now()->format('l, d F Y') }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.admissions.index') }}" class="btn-primary-sc btn-sm-sc"><i class="bi bi-person-plus"></i> New Admission</a>
        <a href="{{ route('admin.notices.create') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-megaphone"></i> Post Notice</a>
    </div>
</div>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-1"><div class="sc-card stat-card"><div class="stat-icon blue"><i class="bi bi-people-fill"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['students'] }}">0</span><span class="stat-label">Total Students</span></div></div></div>
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-2"><div class="sc-card stat-card"><div class="stat-icon purple"><i class="bi bi-person-badge-fill"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['faculty'] }}">0</span><span class="stat-label">Total Faculty</span></div></div></div>
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-3"><div class="sc-card stat-card"><div class="stat-icon green"><i class="bi bi-cash-stack"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ round($stats['total_revenue']/1000) }}">0</span><span class="stat-label">Revenue (₹K)</span></div></div></div>
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-4"><div class="sc-card stat-card"><div class="stat-icon orange"><i class="bi bi-person-plus-fill"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['pending_admissions'] }}">0</span><span class="stat-label">Pending Admissions</span></div></div></div>
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-1"><div class="sc-card stat-card"><div class="stat-icon cyan"><i class="bi bi-building"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['departments'] }}">0</span><span class="stat-label">Departments</span></div></div></div>
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-2"><div class="sc-card stat-card"><div class="stat-icon purple"><i class="bi bi-book"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['courses'] }}">0</span><span class="stat-label">Active Courses</span></div></div></div>
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-3"><div class="sc-card stat-card"><div class="stat-icon red"><i class="bi bi-chat-left-dots"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['open_complaints'] }}">0</span><span class="stat-label">Open Complaints</span></div></div></div>
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-4"><div class="sc-card stat-card"><div class="stat-icon green"><i class="bi bi-clipboard2-check"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['upcoming_exams'] }}">0</span><span class="stat-label">Upcoming Exams</span></div></div></div>
</div>

<!-- Charts Row -->
<div class="row g-3 mb-4">
    <div class="col-lg-8 animate-slide-up anim-delay-2">
        <div class="dashboard-card h-100">
            <div class="card-header-sc"><h5><i class="bi bi-bar-chart me-2 text-primary-sc"></i>Monthly Revenue</h5><span class="sc-badge badge-primary">{{ date('Y') }}</span></div>
            <div class="card-body-sc"><div class="chart-container"><canvas id="revenueChart" data-chart-data="{{ json_encode($monthlyRevenue) }}"></canvas></div></div>
        </div>
    </div>
    <div class="col-lg-4 animate-slide-up anim-delay-3">
        <div class="dashboard-card h-100">
            <div class="card-header-sc"><h5><i class="bi bi-pie-chart me-2 text-primary-sc"></i>Admissions</h5></div>
            <div class="card-body-sc">
                <div class="chart-container" style="height:230px"><canvas id="admissionChart" data-chart-data='{"approved":{{ \App\Models\Admission::where("status","approved")->count() }},"pending":{{ \App\Models\Admission::where("status","pending")->count() }},"rejected":{{ \App\Models\Admission::where("status","rejected")->count() }},"waitlisted":{{ \App\Models\Admission::where("status","waitlisted")->count() }}}'></canvas></div>
                <div class="d-flex justify-content-around mt-3">
                    <div class="text-center"><div style="font-size:1.3rem;font-weight:800;color:var(--success)">{{ \App\Models\Admission::where('status','approved')->count() }}</div><div style="font-size:.7rem;color:var(--text-muted)">Approved</div></div>
                    <div class="text-center"><div style="font-size:1.3rem;font-weight:800;color:var(--warning)">{{ \App\Models\Admission::where('status','pending')->count() }}</div><div style="font-size:.7rem;color:var(--text-muted)">Pending</div></div>
                    <div class="text-center"><div style="font-size:1.3rem;font-weight:800;color:var(--danger)">{{ \App\Models\Admission::where('status','rejected')->count() }}</div><div style="font-size:.7rem;color:var(--text-muted)">Rejected</div></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Data Tables Row -->
<div class="row g-3">
    <div class="col-lg-6 animate-slide-up anim-delay-1">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-person-plus me-2 text-primary-sc"></i>Recent Admissions</h5><a href="{{ route('admin.admissions.index') }}" class="sc-badge badge-primary" style="cursor:pointer">View All</a></div>
            <div class="sc-table-wrapper"><table class="sc-table"><thead><tr><th>Applicant</th><th>Course</th><th>Status</th><th>Date</th></tr></thead><tbody>
            @forelse($recentAdmissions as $adm)
            <tr><td><div style="font-weight:600;font-size:.85rem">{{ $adm->applicant_name }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $adm->applicant_email }}</div></td><td style="font-size:.82rem">{{ Str::limit($adm->course->name ?? '-',20) }}</td><td><span class="sc-badge {{ $adm->status=='approved'?'badge-success':($adm->status=='rejected'?'badge-danger':'badge-warning') }}">{{ ucfirst($adm->status) }}</span></td><td style="font-size:.78rem;color:var(--text-muted)">{{ $adm->created_at->diffForHumans() }}</td></tr>
            @empty<tr><td colspan="4"><div class="text-center py-3" style="color:var(--text-muted);font-size:.85rem">No admissions yet</div></td></tr>@endforelse
            </tbody></table></div>
        </div>
    </div>
    <div class="col-lg-6 animate-slide-up anim-delay-2">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-calendar-event me-2 text-primary-sc"></i>Upcoming Events</h5><a href="{{ route('admin.events.index') }}" class="sc-badge badge-primary">View All</a></div>
            <div class="card-body-sc">
            @forelse($upcomingEvents as $event)
            <div class="d-flex gap-3 mb-3 pb-3" style="border-bottom:1px solid var(--border)">
                <div style="min-width:48px;height:56px;background:var(--gradient-1);border-radius:10px;display:flex;flex-direction:column;align-items:center;justify-content:center;color:white;font-weight:700"><span style="font-size:.6rem;text-transform:uppercase">{{ $event->start_datetime->format('M') }}</span><span style="font-size:1.1rem">{{ $event->start_datetime->format('d') }}</span></div>
                <div><div style="font-weight:600;font-size:.875rem;color:var(--text)">{{ $event->title }}</div><div style="font-size:.75rem;color:var(--text-muted)"><i class="bi bi-geo-alt me-1"></i>{{ $event->venue }}</div></div>
            </div>
            @empty<div class="text-center py-3" style="color:var(--text-muted);font-size:.85rem">No upcoming events</div>@endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6 animate-slide-up anim-delay-3">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-chat-left-text me-2 text-primary-sc"></i>Recent Complaints</h5><a href="{{ route('admin.complaints.index') }}" class="sc-badge badge-danger">{{ $stats['open_complaints'] }} Open</a></div>
            <div class="sc-table-wrapper"><table class="sc-table"><thead><tr><th>Subject</th><th>By</th><th>Priority</th><th>Status</th></tr></thead><tbody>
            @forelse($recentComplaints as $c)
            <tr><td style="font-size:.85rem;font-weight:500">{{ Str::limit($c->subject,30) }}</td><td style="font-size:.78rem">{{ $c->user->name ?? '-' }}</td><td><span class="sc-badge {{ $c->priority=='high'?'badge-danger':($c->priority=='medium'?'badge-warning':'badge-secondary') }}">{{ ucfirst($c->priority) }}</span></td><td><span class="sc-badge {{ $c->status=='open'?'badge-danger':($c->status=='resolved'?'badge-success':'badge-warning') }}">{{ ucfirst($c->status) }}</span></td></tr>
            @empty<tr><td colspan="4" class="text-center py-3" style="color:var(--text-muted)">No complaints</td></tr>@endforelse
            </tbody></table></div>
        </div>
    </div>
    <div class="col-lg-6 animate-slide-up anim-delay-4">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-cash me-2 text-primary-sc"></i>Recent Fee Payments</h5><a href="{{ route('admin.fees.index') }}" class="sc-badge badge-success">View All</a></div>
            <div class="sc-table-wrapper"><table class="sc-table"><thead><tr><th>Student</th><th>Amount</th><th>Method</th><th>Date</th></tr></thead><tbody>
            @forelse($recentFeePayments as $p)
            <tr><td style="font-size:.85rem;font-weight:500">{{ $p->student->user->name ?? '-' }}</td><td style="font-weight:700;color:var(--success)">₹{{ number_format($p->amount_paid) }}</td><td><span class="sc-badge badge-info">{{ ucfirst($p->payment_method) }}</span></td><td style="font-size:.78rem;color:var(--text-muted)">{{ \Carbon\Carbon::parse($p->payment_date)->format('d M Y') }}</td></tr>
            @empty<tr><td colspan="4" class="text-center py-3" style="color:var(--text-muted)">No payments</td></tr>@endforelse
            </tbody></table></div>
        </div>
    </div>
</div>
@endsection
