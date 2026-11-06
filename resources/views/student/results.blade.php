@extends('layouts.dashboard')
@section('title','My Results')
@section('page_title','My Results')
@section('breadcrumb')<a href="{{ route('student.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Results</span>@endsection
@section('sidebar')@include('student.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">My Results</h1><p style="color:var(--text-muted);font-size:.875rem">View your examination results and performance</p></div>
</div>

<!-- Filter -->
<div class="dashboard-card mb-4 animate-slide-up">
    <div class="card-body-sc">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="sc-label">Filter by Examination</label>
                <select name="examination_id" class="sc-select" onchange="this.form.submit()">
                    <option value="">All Examinations</option>
                    @foreach($examinations as $e)
                    <option value="{{ $e->id }}" {{ request('examination_id')==$e->id?'selected':'' }}>{{ $e->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <a href="{{ route('student.results.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-x-lg"></i> Clear</a>
            </div>
        </form>
    </div>
</div>

@if($results->count())
<!-- Summary Stats -->
<div class="row g-3 mb-4">
    @php
    $avgPct = $results->avg('percentage') ?? 0;
    $passed = $results->where('status','pass')->count();
    $failed = $results->where('status','fail')->count();
    @endphp
    <div class="col-6 col-md-3 animate-slide-up anim-delay-1"><div class="sc-card stat-card"><div class="stat-icon blue"><i class="bi bi-file-text"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $results->total() }}">0</span><span class="stat-label">Total Exams</span></div></div></div>
    <div class="col-6 col-md-3 animate-slide-up anim-delay-2"><div class="sc-card stat-card"><div class="stat-icon {{ $avgPct >= 60 ? 'green' : 'orange' }}"><i class="bi bi-percent"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ round($avgPct) }}">0</span><span class="stat-label">Average %</span></div></div></div>
    <div class="col-6 col-md-3 animate-slide-up anim-delay-3"><div class="sc-card stat-card"><div class="stat-icon green"><i class="bi bi-check-circle"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $passed }}">0</span><span class="stat-label">Passed</span></div></div></div>
    <div class="col-6 col-md-3 animate-slide-up anim-delay-4"><div class="sc-card stat-card"><div class="stat-icon red"><i class="bi bi-x-circle"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $failed }}">0</span><span class="stat-label">Failed</span></div></div></div>
</div>
@endif

<div class="dashboard-card animate-slide-up anim-delay-2">
    <div class="card-header-sc"><h5><i class="bi bi-graph-up me-2 text-primary-sc"></i>Result Details</h5></div>
    <div class="sc-table-wrapper">
        <table class="sc-table">
            <thead><tr><th>#</th><th>Subject</th><th>Examination</th><th>Marks</th><th>Percentage</th><th>Grade</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($results as $i => $r)
            <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
                <td style="color:var(--text-muted);font-size:.78rem">{{ $results->firstItem()+$i }}</td>
                <td style="font-weight:600;font-size:.875rem">{{ $r->subject->name ?? '-' }}</td>
                <td style="font-size:.82rem;color:var(--text-muted)">{{ $r->examination->name ?? '-' }}</td>
                <td style="font-weight:700">{{ $r->marks_obtained }}<span style="font-weight:400;color:var(--text-muted)">/{{ $r->total_marks }}</span></td>
                <td>
                    <div style="display:flex;align-items:center;gap:.5rem">
                        <div class="sc-progress" style="flex:1;width:80px"><div class="sc-progress-bar" style="width:{{ min($r->percentage,100) }}%;background:{{ $r->percentage>=75?'var(--success)':($r->percentage>=40?'var(--warning)':'var(--danger)') }}"></div></div>
                        <span style="font-weight:700;font-size:.85rem;color:{{ $r->percentage>=75?'var(--success)':($r->percentage>=40?'var(--warning)':'var(--danger)') }}">{{ number_format($r->percentage,1) }}%</span>
                    </div>
                </td>
                <td>
                    @php
                    $grade = $r->percentage >= 90 ? 'A+' : ($r->percentage >= 80 ? 'A' : ($r->percentage >= 70 ? 'B+' : ($r->percentage >= 60 ? 'B' : ($r->percentage >= 50 ? 'C' : ($r->percentage >= 40 ? 'D' : 'F')))));
                    @endphp
                    <span style="font-weight:900;font-size:1rem;color:{{ $r->percentage>=75?'var(--success)':($r->percentage>=40?'var(--warning)':'var(--danger)') }}">{{ $grade }}</span>
                </td>
                <td><span class="sc-badge {{ $r->status=='pass'?'badge-success':'badge-danger' }}">{{ ucfirst($r->status) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="7">
                <div class="empty-state">
                    <div class="empty-icon"><i class="bi bi-clipboard2-x"></i></div>
                    <h4>No results found</h4>
                    <p>Your results will appear here after examinations are graded</p>
                </div>
            </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($results->hasPages())
    <div class="card-body-sc pt-0">{{ $results->withQueryString()->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
