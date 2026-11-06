@extends('layouts.dashboard')
@section('title','Placements')
@section('page_title','Placements')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><span>Placements</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Placement Records</h1><p style="color:var(--text-muted);font-size:.875rem">{{ $placements->total() }} placements</p></div>
    <a href="{{ route('admin.placements.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg"></i> Add Record</a>
</div>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-1"><div class="sc-card stat-card"><div class="stat-icon blue"><i class="bi bi-briefcase-fill"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['total'] }}">0</span><span class="stat-label">Total Placed</span></div></div></div>
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-2"><div class="sc-card stat-card"><div class="stat-icon green"><i class="bi bi-graph-up-arrow"></i></div><div class="stat-info"><span class="stat-num" style="font-size:1.1rem">₹{{ $stats['avg_package'] }} LPA</span><span class="stat-label">Avg Package</span></div></div></div>
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-3"><div class="sc-card stat-card"><div class="stat-icon purple"><i class="bi bi-trophy-fill"></i></div><div class="stat-info"><span class="stat-num" style="font-size:1.1rem">₹{{ $stats['max_package'] }} LPA</span><span class="stat-label">Highest Package</span></div></div></div>
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-4"><div class="sc-card stat-card"><div class="stat-icon orange"><i class="bi bi-building"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['companies'] }}">0</span><span class="stat-label">Companies</span></div></div></div>
</div>

<div class="dashboard-card mb-4 animate-slide-up">
    <div class="card-body-sc">
        <form method="GET" class="row g-2"><div class="col-md-5"><div class="sc-search-wrapper"><i class="bi bi-search"></i><input type="text" name="search" class="sc-input" placeholder="Search company..." value="{{ request('search') }}"></div></div><div class="col-md-3"><input type="text" name="academic_year" class="sc-input" placeholder="Academic Year e.g. 2024-25" value="{{ request('academic_year') }}"></div><div class="col-md-2 d-flex gap-2"><button type="submit" class="btn-primary-sc btn-sm-sc flex-fill"><i class="bi bi-search"></i></button><a href="{{ route('admin.placements.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-x-lg"></i></a></div></form>
    </div>
</div>

<div class="dashboard-card animate-slide-up anim-delay-2">
    <div class="sc-table-wrapper"><table class="sc-table">
        <thead><tr><th>#</th><th>Student</th><th>Company</th><th>Position</th><th>Package</th><th>Type</th><th>Year</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($placements as $i => $p)
        <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
            <td style="color:var(--text-muted);font-size:.78rem">{{ $placements->firstItem()+$i }}</td>
            <td><div style="font-weight:600;font-size:.875rem">{{ $p->student->user->name ?? '-' }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $p->student->course->name ?? '' }}</div></td>
            <td style="font-weight:600;font-size:.875rem">{{ $p->company_name }}</td>
            <td style="font-size:.82rem">{{ $p->position }}</td>
            <td><span style="font-weight:800;font-size:.95rem;color:var(--success)">₹{{ $p->package_lpa }} LPA</span></td>
            <td><span class="sc-badge badge-info">{{ ucfirst($p->placement_type ?? 'campus') }}</span></td>
            <td style="font-size:.78rem;color:var(--text-muted)">{{ $p->academic_year }}</td>
            <td><span class="sc-badge {{ $p->status=='offered'?'badge-primary':($p->status=='joined'?'badge-success':'badge-secondary') }}">{{ ucfirst($p->status) }}</span></td>
            <td><form method="POST" action="{{ route('admin.placements.destroy',$p) }}" style="display:inline">@csrf @method('DELETE')<button class="table-action-btn delete" data-confirm="Delete placement record?"><i class="bi bi-trash"></i></button></form></td>
        </tr>
        @empty<tr><td colspan="9"><div class="empty-state"><div class="empty-icon"><i class="bi bi-briefcase"></i></div><h4>No placements yet</h4><a href="{{ route('admin.placements.create') }}" class="btn-primary-sc mt-3">Add Record</a></div></td></tr>@endforelse
        </tbody>
    </table></div>
    @if($placements->hasPages())<div class="card-body-sc pt-0">{{ $placements->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
