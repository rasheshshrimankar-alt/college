@extends('layouts.dashboard')
@section('title','Attendance')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Attendance Overview</h1></div><a href="{{ route('admin.attendance.report') }}" class="btn-primary-sc btn-sm-sc"><i class="bi bi-file-earmark-bar-graph"></i> Report</a></div>
<div class="row g-3 mb-4">
<div class="col-md-4 animate-slide-up anim-delay-1"><div class="sc-card stat-card"><div class="stat-icon blue"><i class="bi bi-calendar-check-fill"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['total_records'] }}">0</span><span class="stat-label">Total Records</span></div></div></div>
<div class="col-md-4 animate-slide-up anim-delay-2"><div class="sc-card stat-card"><div class="stat-icon green"><i class="bi bi-person-check-fill"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['present_today'] }}">0</span><span class="stat-label">Present Today</span></div></div></div>
<div class="col-md-4 animate-slide-up anim-delay-3"><div class="sc-card stat-card"><div class="stat-icon orange"><i class="bi bi-percent"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['avg_percentage'] }}">0</span><span class="stat-label">Avg Attendance %</span></div></div></div>
</div>
<div class="dashboard-card animate-slide-up anim-delay-2">
<div class="card-header-sc"><h5><i class="bi bi-calendar-check me-2 text-primary-sc"></i>Attendance Summary by Department</h5></div>
<div class="sc-table-wrapper"><table class="sc-table">
<thead><tr><th>Department</th><th>Total Students</th><th>Avg Attendance</th><th>Progress</th></tr></thead>
<tbody>
@forelse($deptAttendance as $dept)
<tr>
<td style="font-weight:600">{{ $dept->name }}</td>
<td>{{ $dept->students_count }}</td>
<td><span style="font-weight:700;color:{{ $dept->avg_pct>=75?'var(--success)':'var(--warning)' }}">{{ number_format($dept->avg_pct??75,1) }}%</span></td>
<td><div class="sc-progress"><div class="sc-progress-bar" style="width:{{ $dept->avg_pct??75 }}%;background:{{ ($dept->avg_pct??75)>=75?'var(--success)':'var(--warning)' }}"></div></div></td>
</tr>
@empty<tr><td colspan="4" class="text-center py-4" style="color:var(--text-muted)">No attendance data</td></tr>@endforelse
</tbody></table></div>
</div>
@endsection
