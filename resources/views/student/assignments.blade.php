@extends('layouts.dashboard')
@section('title','Assignments')
@section('page_title','Assignments')
@section('breadcrumb')<a href="{{ route('student.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Assignments</span>@endsection
@section('sidebar')@include('student.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">My Assignments</h1><p style="color:var(--text-muted);font-size:.875rem">View and track your assignments</p></div>
</div>

<div class="dashboard-card animate-slide-up">
    <div class="sc-table-wrapper">
        <table class="sc-table">
            <thead><tr><th>#</th><th>Assignment</th><th>Subject</th><th>Due Date</th><th>Max Marks</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($assignments as $i => $a)
            <tr style="animation:fadeInLeft .4s ease {{ $i*0.05 }}s both">
                <td style="color:var(--text-muted);font-size:.78rem">{{ $assignments->firstItem()+$i }}</td>
                <td>
                    <div style="font-weight:600;font-size:.875rem">{{ $a->title }}</div>
                    @if($a->description)<div style="font-size:.72rem;color:var(--text-muted)">{{ Str::limit($a->description,60) }}</div>@endif
                    @if($a->faculty)<div style="font-size:.72rem;color:var(--primary)"><i class="bi bi-person me-1"></i>{{ $a->faculty->user->name ?? '' }}</div>@endif
                </td>
                <td style="font-size:.82rem">{{ $a->subject->name ?? '-' }}</td>
                <td>
                    <div style="font-size:.85rem;font-weight:{{ now()->gt($a->due_date)?'700':'500' }};color:{{ now()->gt($a->due_date)?'var(--danger)':'var(--text)' }}">
                        {{ $a->due_date ? $a->due_date->format('d M Y') : '-' }}
                    </div>
                    @if(now()->gt($a->due_date))<span class="sc-badge badge-danger" style="font-size:.6rem">Overdue</span>@else<span class="sc-badge badge-info" style="font-size:.6rem">{{ now()->diffInDays($a->due_date) }}d left</span>@endif
                </td>
                <td style="font-weight:700;color:var(--primary)">{{ $a->max_marks ?? $a->total_marks ?? 10 }}</td>
                <td>
                    @php
                    $submitted = $a->submissions ? $a->submissions->where('student_id', $student->id ?? 0)->first() : null;
                    @endphp
                    @if($submitted)
                        <span class="sc-badge badge-success">Submitted</span>
                    @elseif(now()->gt($a->due_date))
                        <span class="sc-badge badge-danger">Overdue</span>
                    @else
                        <span class="sc-badge badge-warning">Pending</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6">
                <div class="empty-state">
                    <div class="empty-icon"><i class="bi bi-clipboard-check"></i></div>
                    <h4>No assignments yet</h4>
                    <p>No assignments have been posted for your course</p>
                </div>
            </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($assignments->hasPages())
    <div class="card-body-sc pt-0">{{ $assignments->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
