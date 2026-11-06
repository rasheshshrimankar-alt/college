@extends('layouts.dashboard')
@section('title','Assignments')
@section('page_title','Assignments')
@section('breadcrumb')<a href="{{ route('faculty.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Assignments</span>@endsection
@section('sidebar')@include('faculty.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Assignments</h1><p style="color:var(--text-muted);font-size:.875rem">Manage and track student assignments</p></div>
    <a href="{{ route('faculty.assignments.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg"></i> Create Assignment</a>
</div>

<div class="dashboard-card animate-slide-up">
    <div class="sc-table-wrapper">
        <table class="sc-table">
            <thead><tr><th>#</th><th>Title</th><th>Subject</th><th>Due Date</th><th>Max Marks</th><th>Submissions</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($assignments as $i => $a)
            <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
                <td style="color:var(--text-muted);font-size:.78rem">{{ $assignments->firstItem()+$i }}</td>
                <td><div style="font-weight:600;font-size:.875rem">{{ $a->title }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $a->description ? Str::limit($a->description,40) : '' }}</div></td>
                <td style="font-size:.82rem">{{ $a->subject->name ?? '-' }}</td>
                <td>
                    <span style="font-size:.82rem;color:{{ now()->gt($a->due_date)?'var(--danger)':'var(--text)' }};font-weight:{{ now()->gt($a->due_date)?'700':'400' }}">
                        {{ $a->due_date ? $a->due_date->format('d M Y') : '-' }}
                        @if(now()->gt($a->due_date))<span class="sc-badge badge-danger ms-1" style="font-size:.6rem">Overdue</span>@endif
                    </span>
                </td>
                <td style="font-weight:700;color:var(--primary)">{{ $a->max_marks ?? $a->total_marks ?? 10 }}</td>
                <td><span class="sc-badge badge-info">{{ $a->submissions_count ?? 0 }} submitted</span></td>
                <td><span class="sc-badge {{ $a->status=='active'?'badge-success':'badge-secondary' }}">{{ ucfirst($a->status) }}</span></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('faculty.assignments.edit', $a) }}" class="table-action-btn edit"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('faculty.assignments.destroy', $a) }}" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="table-action-btn delete" data-confirm="Delete this assignment?"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8">
                <div class="empty-state">
                    <div class="empty-icon"><i class="bi bi-clipboard-x"></i></div>
                    <h4>No assignments yet</h4>
                    <p>Create your first assignment for students</p>
                    <a href="{{ route('faculty.assignments.create') }}" class="btn-primary-sc mt-3">Create Assignment</a>
                </div>
            </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($assignments->hasPages())
    <div class="card-body-sc pt-0">{{ $assignments->withQueryString()->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
