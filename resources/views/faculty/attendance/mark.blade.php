@extends('layouts.dashboard')
@section('title','Mark Attendance')
@section('sidebar')@include('faculty.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Mark Attendance</h1></div>
    <a href="{{ route('faculty.attendance.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a>
</div>
<div class="dashboard-card mb-4 animate-slide-up"><div class="card-body-sc">
    <form method="GET" class="row g-2">
        <div class="col-md-5">
            <div class="sc-form-group mb-0"><label class="sc-label">Select Subject</label>
            <select name="subject_id" class="sc-select" onchange="this.form.submit()">
                <option value="">Choose Subject</option>
                @foreach($subjects as $s)<option value="{{ $s->id }}" {{ $subjectId==$s->id?'selected':'' }}>{{ $s->name }} ({{ $s->code }})</option>@endforeach
            </select></div>
        </div>
    </form>
</div></div>

@if($students->count())
<div class="dashboard-card animate-slide-up anim-delay-2">
    <div class="card-header-sc">
        <h5><i class="bi bi-calendar-check me-2 text-primary-sc"></i>{{ \Carbon\Carbon::today()->format('l, d F Y') }}</h5>
        <div class="d-flex gap-2">
            <button type="button" onclick="markAll('present')" class="btn-primary-sc btn-sm-sc"><i class="bi bi-check-all me-1"></i>All Present</button>
            <button type="button" onclick="markAll('absent')" class="btn-outline-sc btn-sm-sc"><i class="bi bi-x me-1"></i>All Absent</button>
        </div>
    </div>
    <div class="card-body-sc">
    <form method="POST" action="{{ route('faculty.attendance.mark.store') }}">@csrf
        <input type="hidden" name="subject_id" value="{{ $subjectId }}">
        <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
        <div class="sc-table-wrapper"><table class="sc-table">
            <thead><tr><th>#</th><th>Student</th><th>Roll No.</th><th class="text-center">Present</th><th class="text-center">Absent</th><th class="text-center">Late</th></tr></thead>
            <tbody>
            @foreach($students as $i => $student)
            <tr>
                <td style="color:var(--text-muted);font-size:.78rem">{{ $i+1 }}</td>
                <td><div class="d-flex align-items-center gap-2"><img src="{{ $student->user->avatar_url }}" style="width:30px;height:30px;border-radius:50%"><span style="font-weight:600;font-size:.875rem">{{ $student->user->name }}</span></div></td>
                <td><code style="font-size:.72rem;color:var(--primary)">{{ $student->roll_number }}</code></td>
                <td class="text-center"><input type="radio" name="attendance[{{ $student->id }}]" value="present" class="att-radio" style="width:18px;height:18px;accent-color:var(--success)" checked></td>
                <td class="text-center"><input type="radio" name="attendance[{{ $student->id }}]" value="absent" class="att-radio" style="width:18px;height:18px;accent-color:var(--danger)"></td>
                <td class="text-center"><input type="radio" name="attendance[{{ $student->id }}]" value="late" class="att-radio" style="width:18px;height:18px;accent-color:var(--warning)"></td>
            </tr>
            @endforeach
            </tbody>
        </table></div>
        <div class="mt-4"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Save Attendance ({{ $students->count() }} students)</button></div>
    </form>
    </div>
</div>
@elseif($subjectId)
<div class="dashboard-card animate-slide-up"><div class="empty-state py-5"><div class="empty-icon"><i class="bi bi-people"></i></div><h4>No students found for this subject</h4></div></div>
@else
<div class="dashboard-card animate-slide-up"><div class="empty-state py-5"><div class="empty-icon"><i class="bi bi-calendar-check"></i></div><h4>Select a subject to mark attendance</h4></div></div>
@endif

@push('scripts')
<script>
function markAll(status) {
    document.querySelectorAll('input.att-radio[value='+status+']').forEach(r => r.checked = true);
}
</script>
@endpush
@endsection
