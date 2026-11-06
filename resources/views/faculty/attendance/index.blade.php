@extends('layouts.dashboard')
@section('title','Attendance')
@section('sidebar')@include('faculty.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Attendance Records</h1></div>
    <a href="{{ route('faculty.attendance.take') }}" class="btn-primary-sc"><i class="bi bi-calendar-check me-1"></i>Mark Attendance</a>
</div>
<div class="dashboard-card mb-4 animate-slide-up"><div class="card-body-sc">
    <form method="GET" class="row g-2">
        <div class="col-md-4"><select name="subject_id" class="sc-select"><option value="">All Subjects</option>@foreach($subjects as $s)<option value="{{ $s->id }}" {{ request('subject_id')==$s->id?'selected':'' }}>{{ $s->name }}</option>@endforeach</select></div>
        <div class="col-md-3"><input type="date" name="date" class="sc-input" value="{{ request('date') }}"></div>
        <div class="col-md-2 d-flex gap-2"><button type="submit" class="btn-primary-sc btn-sm-sc flex-fill"><i class="bi bi-search"></i></button><a href="{{ route('faculty.attendance.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-x-lg"></i></a></div>
    </form>
</div></div>
<div class="dashboard-card animate-slide-up anim-delay-2">
    <div class="sc-table-wrapper"><table class="sc-table">
        <thead><tr><th>Date</th><th>Student</th><th>Subject</th><th>Status</th></tr></thead>
        <tbody>
        @forelse($attendance as $i => $att)
        <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
            <td style="font-weight:600;font-size:.85rem">{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}</td>
            <td>{{ $att->student->user->name ?? '-' }}</td>
            <td style="font-size:.82rem">{{ $att->subject->name ?? '-' }}</td>
            <td><span class="sc-badge {{ $att->status=='present'?'badge-success':($att->status=='absent'?'badge-danger':'badge-warning') }}">{{ ucfirst($att->status) }}</span></td>
        </tr>
        @empty
        <tr><td colspan="4"><div class="empty-state"><div class="empty-icon"><i class="bi bi-calendar-x"></i></div><h4>No attendance records</h4><a href="{{ route('faculty.attendance.take') }}" class="btn-primary-sc mt-3">Mark Attendance</a></div></td></tr>
        @endforelse
        </tbody>
    </table></div>
    @if($attendance->hasPages())<div class="card-body-sc pt-0">{{ $attendance->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
