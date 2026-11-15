@extends('layouts.dashboard')
@section('title','Assignments')
@section('page_title','Assignments')
@section('breadcrumb')<a href="{{ route('student.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Assignments</span>@endsection
@section('sidebar')@include('student.partials.sidebar')@endsection

@section('content')
@if(session('success'))<div class="sc-alert success mb-3">{{ session('success') }}</div>@endif
@if($errors->any())<div class="sc-alert danger mb-3">{{ $errors->first() }}</div>@endif
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">My Assignments</h1><p style="color:var(--text-muted);font-size:.875rem">View and track your assignments</p></div>
</div>

<div class="dashboard-card animate-slide-up">
    <div class="sc-table-wrapper">
        <table class="sc-table">
            <thead><tr><th>#</th><th>Assignment</th><th>Subject</th><th>Due Date</th><th>Max Marks</th><th>Status / Submit</th></tr></thead>
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
                        <span class="sc-badge badge-success">{{ $submitted->status === 'graded' ? 'Graded: '.number_format((float)$submitted->marks_obtained, 1) : 'Submitted' }}</span>
                    @elseif(now()->gt($a->due_date))
                        <span class="sc-badge badge-danger">Overdue</span>
                    @else
                        <form method="POST" action="{{ route('student.assignments.submit', $a) }}" enctype="multipart/form-data" class="d-flex flex-column gap-1" style="min-width:170px">
                            @csrf
                            <input type="file" name="submission_file" class="form-control form-control-sm" accept=".pdf,.doc,.docx,.zip,.jpg,.png" required aria-label="Assignment file">
                            <input type="text" name="remarks" class="form-control form-control-sm" placeholder="Optional note" maxlength="1000">
                            <button type="submit" class="btn-primary-sc btn-sm-sc" style="justify-content:center"><i class="bi bi-upload me-1"></i>Submit</button>
                        </form>
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
