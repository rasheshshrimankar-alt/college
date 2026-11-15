@extends('layouts.dashboard')
@section('title','Timetable')
@section('page_title','Timetable')
@section('sidebar')@include('student.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Class Timetable</h1><p style="color:var(--text-muted);font-size:.875rem">{{ $student->course->name ?? 'Course' }} — Semester {{ $student->current_semester ?? 1 }}</p></div></div>
<div class="dashboard-card animate-slide-up">
    <div class="card-header-sc"><h5><i class="bi bi-calendar-week me-2 text-primary-sc"></i>Published Weekly Schedule</h5></div>
    <div class="sc-table-wrapper">
        <table class="sc-table">
            <thead><tr><th>Day</th><th>Time</th><th>Subject</th><th>Faculty</th><th>Room</th></tr></thead>
            <tbody>
            @forelse($timetableEntries as $entry)
                <tr>
                    <td class="fw-semibold">{{ $entry->day_of_week }}</td>
                    <td>{{ \Carbon\Carbon::parse($entry->start_time)->format('h:i A') }} – {{ \Carbon\Carbon::parse($entry->end_time)->format('h:i A') }}</td>
                    <td><div class="fw-semibold">{{ $entry->subject->name ?? '-' }}</div><small class="text-muted">{{ $entry->subject->code ?? '' }}</small></td>
                    <td>{{ $entry->faculty->user->name ?? '-' }}</td>
                    <td>{{ $entry->room ?: 'To be announced' }}</td>
                </tr>
            @empty
                <tr><td colspan="5"><div class="empty-state py-5"><div class="empty-icon"><i class="bi bi-calendar-x"></i></div><h4>No timetable published yet</h4><p>Your department has not published a schedule for this semester.</p></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
