@extends('layouts.dashboard')
@section('title','Attendance Report')
@section('sidebar')@include('faculty.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Attendance Report</h1></div></div>
<div class="dashboard-card mb-4 animate-slide-up"><div class="card-body-sc">
    <form method="GET" class="row g-2">
        <div class="col-md-5"><select name="subject_id" class="sc-select" onchange="this.form.submit()"><option value="">Select Subject to View Report</option>@foreach($subjects as $s)<option value="{{ $s->id }}" {{ $subjectId==$s->id?'selected':'' }}>{{ $s->name }} ({{ $s->code }})</option>@endforeach</select></div>
        @if($subjectId)<div class="col-md-2"><a href="{{ route('faculty.attendance.report') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-x-lg"></i> Clear</a></div>@endif
    </form>
</div></div>

@if($students->count())
<div class="dashboard-card animate-slide-up anim-delay-2">
    <div class="sc-table-wrapper"><table class="sc-table">
        <thead><tr><th>Student</th><th>Total Classes</th><th>Present</th><th>Absent</th><th>Percentage</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($students as $s)
        @php $total=$s->attendance->count(); $present=$s->attendance->where('status','present')->count(); $pct=$total>0?round($present/$total*100,1):0; @endphp
        <tr>
            <td><div style="font-weight:600;font-size:.875rem">{{ $s->user->name }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $s->student_id }}</div></td>
            <td style="font-weight:700">{{ $total }}</td>
            <td style="color:var(--success);font-weight:700">{{ $present }}</td>
            <td style="color:var(--danger);font-weight:700">{{ $total - $present }}</td>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <div class="sc-progress" style="flex:1;min-width:80px"><div class="sc-progress-bar" style="width:{{ $pct }}%;background:{{ $pct>=75?'var(--success)':($pct>=65?'var(--warning)':'var(--danger)') }}"></div></div>
                    <span style="font-weight:800;color:{{ $pct>=75?'var(--success)':($pct>=65?'var(--warning)':'var(--danger)') }}">{{ $pct }}%</span>
                </div>
            </td>
            <td><span class="sc-badge {{ $pct>=75?'badge-success':($pct>=65?'badge-warning':'badge-danger') }}">{{ $pct>=75?'Good':($pct>=65?'Average':'At Risk') }}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table></div>
</div>
@else
<div class="dashboard-card animate-slide-up"><div class="empty-state py-5"><div class="empty-icon"><i class="bi bi-bar-chart"></i></div><h4>Select a subject to view the attendance report</h4></div></div>
@endif
@endsection
