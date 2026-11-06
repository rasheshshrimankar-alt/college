@extends('layouts.dashboard')
@section('title','My Attendance')
@section('page_title','My Attendance')
@section('breadcrumb')<a href="{{ route('student.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Attendance</span>@endsection
@section('sidebar')@include('student.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">My Attendance</h1><p style="color:var(--text-muted);font-size:.875rem">Track your attendance across all subjects</p></div>
</div>

<!-- Subject-wise Summary -->
@if(count($summary))
<div class="dashboard-card mb-4 animate-slide-up anim-delay-1">
    <div class="card-header-sc"><h5><i class="bi bi-pie-chart me-2 text-primary-sc"></i>Subject-wise Summary</h5></div>
    <div class="card-body-sc">
        <div class="row g-3">
            @foreach($summary as $s)
            <div class="col-md-6 col-lg-4">
                <div style="background:var(--bg);border-radius:10px;padding:1rem;border:1px solid var(--border)">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div style="font-weight:600;font-size:.875rem;color:var(--text)">{{ $s['subject'] }}</div>
                        <span style="font-weight:800;font-size:.95rem;color:{{ $s['percentage']>=75?'var(--success)':($s['percentage']>=65?'var(--warning)':'var(--danger)') }}">{{ $s['percentage'] }}%</span>
                    </div>
                    <div class="sc-progress mb-1"><div class="sc-progress-bar" data-width="{{ $s['percentage'] }}" style="width:{{ $s['percentage'] }}%;background:{{ $s['percentage']>=75?'var(--success)':($s['percentage']>=65?'var(--warning)':'var(--danger)') }};transition:width 1s ease"></div></div>
                    <div style="font-size:.72rem;color:var(--text-muted)">{{ $s['present'] }} present / {{ $s['total'] }} classes</div>
                    @if($s['percentage'] < 75)<div style="font-size:.72rem;color:var(--danger);margin-top:.25rem;font-weight:600"><i class="bi bi-exclamation-triangle me-1"></i>Below 75% – At Risk</div>@endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Filter + Detail Table -->
<div class="dashboard-card animate-slide-up anim-delay-2">
    <div class="card-header-sc"><h5><i class="bi bi-calendar-check me-2 text-primary-sc"></i>Attendance Log</h5></div>
    <div class="card-body-sc pb-0">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-4">
                <select name="subject_id" class="sc-select" onchange="this.form.submit()">
                    <option value="">All Subjects</option>
                    @foreach($subjects as $sub)<option value="{{ $sub->id }}" {{ request('subject_id')==$sub->id?'selected':'' }}>{{ $sub->name }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="month" class="sc-select" onchange="this.form.submit()">
                    <option value="">All Months</option>
                    @foreach(range(1,12) as $m)<option value="{{ $m }}" {{ request('month')==$m?'selected':'' }}>{{ date('F',mktime(0,0,0,$m,1)) }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-2"><a href="{{ route('student.attendance.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-x-lg"></i></a></div>
        </form>
    </div>
    <div class="sc-table-wrapper">
        <table class="sc-table">
            <thead><tr><th>Date</th><th>Subject</th><th>Status</th><th>Remarks</th></tr></thead>
            <tbody>
            @forelse($attendance as $i => $att)
            <tr style="animation:fadeInLeft .4s ease {{ $i*0.03 }}s both">
                <td style="font-weight:600;font-size:.85rem">{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}<br><span style="font-size:.72rem;color:var(--text-muted)">{{ \Carbon\Carbon::parse($att->date)->format('l') }}</span></td>
                <td style="font-size:.82rem">{{ $att->subject->name ?? '-' }}</td>
                <td>
                    <span class="sc-badge {{ $att->status=='present'?'badge-success':($att->status=='absent'?'badge-danger':'badge-warning') }}">
                        <i class="bi bi-{{ $att->status=='present'?'check-circle':'x-circle' }} me-1"></i>{{ ucfirst($att->status) }}
                    </span>
                </td>
                <td style="font-size:.78rem;color:var(--text-muted)">{{ $att->remarks ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="4">
                <div class="empty-state py-4">
                    <div class="empty-icon"><i class="bi bi-calendar-x"></i></div>
                    <h4>No attendance records</h4>
                    <p>No attendance data found for the selected filters</p>
                </div>
            </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($attendance->hasPages())
    <div class="card-body-sc pt-0">{{ $attendance->withQueryString()->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
