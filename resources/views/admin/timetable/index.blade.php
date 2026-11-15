@extends('layouts.dashboard')
@section('title','Timetable Management')
@section('page_title','Timetable Management')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header"><div><h1 class="page-title">Timetable Management</h1><p class="text-muted small">Publish class schedules for student dashboards.</p></div></div>
@if(session('success'))<div class="sc-alert success mb-3">{{ session('success') }}</div>@endif
@if($errors->any())<div class="sc-alert danger mb-3">{{ $errors->first() }}</div>@endif
<div class="dashboard-card mb-4">
    <div class="card-header-sc"><h5><i class="bi bi-calendar-plus me-2"></i>Add timetable entry</h5></div>
    <div class="card-body-sc">
        <form method="POST" action="{{ route('admin.timetable.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4"><label class="sc-label">Course</label><select name="course_id" class="sc-select" required><option value="">Select course</option>@foreach($courses as $course)<option value="{{ $course->id }}" @selected(old('course_id')==$course->id)>{{ $course->name }}</option>@endforeach</select></div>
                <div class="col-md-4"><label class="sc-label">Subject</label><select name="subject_id" class="sc-select" required><option value="">Select subject</option>@foreach($subjects as $subject)<option value="{{ $subject->id }}" @selected(old('subject_id')==$subject->id)>{{ $subject->name }} ({{ $subject->code }})</option>@endforeach</select></div>
                <div class="col-md-4"><label class="sc-label">Faculty</label><select name="faculty_id" class="sc-select" required><option value="">Select faculty</option>@foreach($faculty as $member)<option value="{{ $member->id }}" @selected(old('faculty_id')==$member->id)>{{ $member->user->name ?? 'Faculty' }}</option>@endforeach</select></div>
                <div class="col-md-3"><label class="sc-label">Day</label><select name="day_of_week" class="sc-select" required>@foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)<option value="{{ $day }}" @selected(old('day_of_week')==$day)>{{ $day }}</option>@endforeach</select></div>
                <div class="col-md-2"><label class="sc-label">Semester</label><input type="number" name="semester" class="sc-input" min="1" max="12" value="{{ old('semester',1) }}" required></div>
                <div class="col-md-2"><label class="sc-label">Start</label><input type="time" name="start_time" class="sc-input" value="{{ old('start_time') }}" required></div>
                <div class="col-md-2"><label class="sc-label">End</label><input type="time" name="end_time" class="sc-input" value="{{ old('end_time') }}" required></div>
                <div class="col-md-3"><label class="sc-label">Room</label><input type="text" name="room" class="sc-input" maxlength="60" value="{{ old('room') }}" placeholder="Room 101"></div>
                <div class="col-md-4"><label class="sc-label">Academic year</label><input type="text" name="academic_year" class="sc-input" maxlength="20" value="{{ old('academic_year', now()->year.'-'.(now()->year+1)) }}" required></div>
            </div>
            <button class="btn-primary-sc mt-3" type="submit"><i class="bi bi-plus-lg me-1"></i>Publish entry</button>
        </form>
    </div>
</div>
<div class="dashboard-card">
    <div class="card-header-sc"><h5>Published timetable</h5></div>
    <div class="sc-table-wrapper"><table class="sc-table">
        <thead><tr><th>Course</th><th>Semester</th><th>Day</th><th>Time</th><th>Subject</th><th>Faculty</th><th>Room</th><th></th></tr></thead>
        <tbody>
        @forelse($entries as $entry)
            <tr><td>{{ $entry->course->name ?? '-' }}</td><td>{{ $entry->semester }}</td><td>{{ $entry->day_of_week }}</td>
                <td>{{ \Carbon\Carbon::parse($entry->start_time)->format('h:i A') }}–{{ \Carbon\Carbon::parse($entry->end_time)->format('h:i A') }}</td>
                <td>{{ $entry->subject->name ?? '-' }}</td><td>{{ $entry->faculty->user->name ?? '-' }}</td><td>{{ $entry->room ?: '-' }}</td>
                <td><form method="POST" action="{{ route('admin.timetable.destroy',$entry) }}" onsubmit="return confirm('Remove this timetable entry?')">@csrf @method('DELETE')<button class="table-action-btn delete" type="submit"><i class="bi bi-trash"></i></button></form></td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center py-4">No timetable entries published yet.</td></tr>
        @endforelse
        </tbody>
    </table></div>
    <div class="card-body-sc">{{ $entries->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
