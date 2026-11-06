@extends('layouts.dashboard')
@section('title','My Students')
@section('page_title','My Students')
@section('breadcrumb')<a href="{{ route('faculty.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Students</span>@endsection
@section('sidebar')@include('faculty.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">My Students</h1><p style="color:var(--text-muted);font-size:.875rem">{{ $students->total() }} students in your department</p></div>
</div>
<div class="dashboard-card animate-slide-up">
    <div class="sc-table-wrapper"><table class="sc-table">
        <thead><tr><th>#</th><th>Student</th><th>Student ID</th><th>Course</th><th>Semester</th><th>Status</th></tr></thead>
        <tbody>
        @forelse($students as $i => $s)
        <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
            <td style="color:var(--text-muted);font-size:.78rem">{{ $students->firstItem()+$i }}</td>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ $s->user->avatar_url }}" style="width:34px;height:34px;border-radius:50%;border:2px solid var(--primary-light)">
                    <div><div style="font-weight:600;font-size:.875rem">{{ $s->user->name }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $s->user->email }}</div></div>
                </div>
            </td>
            <td><code style="font-size:.75rem;background:var(--primary-light);color:var(--primary);padding:2px 6px;border-radius:4px">{{ $s->student_id }}</code></td>
            <td style="font-size:.82rem">{{ Str::limit($s->course->name ?? '-', 22) }}</td>
            <td><span class="sc-badge badge-info">Sem {{ $s->current_semester ?? 1 }}</span></td>
            <td><span class="sc-badge {{ $s->status=='active'?'badge-success':'badge-secondary' }}">{{ ucfirst($s->status) }}</span></td>
        </tr>
        @empty
        <tr><td colspan="6"><div class="empty-state py-4"><div class="empty-icon"><i class="bi bi-people"></i></div><h4>No students found</h4></div></td></tr>
        @endforelse
        </tbody>
    </table></div>
    @if($students->hasPages())<div class="card-body-sc pt-0">{{ $students->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
