@extends('layouts.dashboard')
@section('title','Exam Results')
@section('page_title','Exam Results')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><a href="{{ route('admin.examinations.index') }}">Examinations</a><i class="bi bi-chevron-right"></i><span>Results</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">{{ $examination->name }}</h1><p style="color:var(--text-muted);font-size:.875rem">{{ $examination->course->name ?? '' }} — Semester {{ $examination->semester }}</p></div>
    <a href="{{ route('admin.results.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg"></i> Enter Results</a>
</div>
<div class="dashboard-card animate-slide-up">
    <div class="sc-table-wrapper"><table class="sc-table">
        <thead><tr><th>#</th><th>Student</th><th>Subject</th><th>Marks</th><th>Percentage</th><th>Status</th></tr></thead>
        <tbody>
        @forelse($results as $i => $r)
        <tr>
            <td style="font-size:.78rem;color:var(--text-muted)">{{ $results->firstItem()+$i }}</td>
            <td><div style="font-weight:600;font-size:.875rem">{{ $r->student->user->name ?? '-' }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $r->student->student_id ?? '' }}</div></td>
            <td style="font-size:.82rem">{{ $r->subject->name ?? '-' }}</td>
            <td style="font-weight:700">{{ $r->marks_obtained }}<span style="font-weight:400;color:var(--text-muted)">/{{ $r->total_marks }}</span></td>
            <td><span style="font-weight:700;color:{{ $r->percentage>=60?'var(--success)':($r->percentage>=40?'var(--warning)':'var(--danger)') }}">{{ number_format($r->percentage,1) }}%</span></td>
            <td><span class="sc-badge {{ $r->status=='pass'?'badge-success':'badge-danger' }}">{{ ucfirst($r->status) }}</span></td>
        </tr>
        @empty
        <tr><td colspan="6"><div class="empty-state py-4"><div class="empty-icon"><i class="bi bi-clipboard2-x"></i></div><h4>No results entered yet</h4><a href="{{ route('admin.results.create') }}" class="btn-primary-sc mt-3">Enter Results</a></div></td></tr>
        @endforelse
        </tbody>
    </table></div>
    @if($results->hasPages())<div class="card-body-sc pt-0">{{ $results->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
