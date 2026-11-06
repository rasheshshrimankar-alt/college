@extends('layouts.dashboard')
@section('title','Faculty Dashboard')
@section('page_title','Faculty Dashboard')
@section('breadcrumb')<span>Dashboard</span>@endsection

@section('sidebar')@include('faculty.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div>
        <h1 class="page-title">Welcome, {{ Str::limit(auth()->user()->name,20) }}! 👋</h1>
        <p style="color:var(--text-muted);font-size:.875rem;margin:0">{{ $faculty->designation }} — {{ $faculty->department->name ?? 'Faculty' }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('faculty.attendance.take') }}" class="btn-primary-sc btn-sm-sc"><i class="bi bi-calendar-check"></i> Take Attendance</a>
        <a href="{{ route('faculty.assignments.create') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-plus"></i> Assignment</a>
    </div>
</div>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-1"><div class="sc-card stat-card"><div class="stat-icon blue"><i class="bi bi-people-fill"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $myStudents }}">0</span><span class="stat-label">My Students</span></div></div></div>
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-2"><div class="sc-card stat-card"><div class="stat-icon green"><i class="bi bi-clipboard-check"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $myAssignments }}">0</span><span class="stat-label">Assignments Posted</span></div></div></div>
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-3"><div class="sc-card stat-card"><div class="stat-icon purple"><i class="bi bi-graph-up"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $resultsEntered }}">0</span><span class="stat-label">Results Entered</span></div></div></div>
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-4"><div class="sc-card stat-card"><div class="stat-icon orange"><i class="bi bi-file-earmark-text"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $myMaterials }}">0</span><span class="stat-label">Materials Shared</span></div></div></div>
</div>

<!-- Faculty Info + Today's Schedule -->
<div class="row g-3 mb-4">
    <div class="col-lg-4 animate-slide-up anim-delay-1">
        <div class="dashboard-card h-100">
            <div class="card-header-sc"><h5><i class="bi bi-person-badge me-2 text-primary-sc"></i>My Profile</h5><a href="{{ route('faculty.profile') }}" class="sc-badge badge-primary">Edit</a></div>
            <div class="card-body-sc text-center">
                <img src="{{ auth()->user()->avatar_url }}" style="width:80px;height:80px;border-radius:50%;border:4px solid var(--primary-light);margin-bottom:1rem" alt="">
                <h5 style="font-weight:800;font-size:1rem">{{ auth()->user()->name }}</h5>
                <div style="font-size:.82rem;color:var(--primary);font-weight:600;margin-bottom:.25rem">{{ $faculty->designation }}</div>
                <div style="font-size:.78rem;color:var(--text-muted);margin-bottom:.75rem">{{ $faculty->department->name ?? '-' }}</div>
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    <span class="sc-badge badge-secondary">{{ $faculty->faculty_id }}</span>
                    @if($faculty->qualification)<span class="sc-badge badge-info">{{ Str::limit($faculty->qualification,20) }}</span>@endif
                    @if($faculty->experience)<span class="sc-badge badge-secondary" style="font-size:.62rem">{{ $faculty->experience }}</span>@endif
                </div>
                <div class="mt-3" style="border-top:1px solid var(--border);padding-top:1rem">
                    @if($faculty->specialization)<div style="font-size:.78rem;color:var(--text-muted)"><i class="bi bi-lightbulb me-1"></i>{{ $faculty->specialization }}</div>@endif
                    @if($faculty->joining_date)<div style="font-size:.78rem;color:var(--text-muted);margin-top:.3rem"><i class="bi bi-calendar me-1"></i>Joined {{ \Carbon\Carbon::parse($faculty->joining_date)->format('M Y') }}</div>@endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 animate-slide-up anim-delay-2">
        <div class="dashboard-card h-100">
            <div class="card-header-sc"><h5><i class="bi bi-people me-2 text-primary-sc"></i>Recent Students</h5><a href="{{ route('faculty.students') }}" class="sc-badge badge-primary">View All</a></div>
            <div class="sc-table-wrapper"><table class="sc-table"><thead><tr><th>Student</th><th>ID</th><th>Course</th><th>Semester</th><th>Status</th></tr></thead><tbody>
            @forelse($recentStudents as $i => $s)
            <tr style="animation:fadeInLeft .4s ease {{ $i*0.05 }}s both">
                <td><div class="d-flex align-items-center gap-2"><img src="{{ $s->user->avatar_url }}" style="width:30px;height:30px;border-radius:50%"><div style="font-weight:600;font-size:.85rem">{{ $s->user->name }}</div></div></td>
                <td><code style="font-size:.72rem;color:var(--primary);background:var(--primary-light);padding:1px 5px;border-radius:4px">{{ $s->student_id }}</code></td>
                <td style="font-size:.8rem">{{ Str::limit($s->course->name ?? '-',20) }}</td>
                <td><span class="sc-badge badge-info" style="font-size:.62rem">Sem {{ $s->current_semester ?? 1 }}</span></td>
                <td><span class="sc-badge {{ $s->status=='active'?'badge-success':'badge-secondary' }}" style="font-size:.62rem">{{ ucfirst($s->status) }}</span></td>
            </tr>
            @empty<tr><td colspan="5" class="text-center py-3" style="color:var(--text-muted)">No students assigned</td></tr>@endforelse
            </tbody></table></div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row g-3">
    <div class="col-lg-6 animate-slide-up anim-delay-1">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-clipboard-check me-2 text-primary-sc"></i>My Assignments</h5><a href="{{ route('faculty.assignments.create') }}" class="sc-badge badge-primary">+ New</a></div>
            <div class="sc-table-wrapper"><table class="sc-table"><thead><tr><th>Title</th><th>Subject</th><th>Due</th><th>Submissions</th></tr></thead><tbody>
            @forelse($recentAssignments as $a)
            <tr><td style="font-weight:600;font-size:.85rem">{{ Str::limit($a->title,30) }}</td><td style="font-size:.78rem;color:var(--text-muted)">{{ $a->subject->name ?? '-' }}</td><td style="font-size:.75rem;color:{{ now()->gt($a->due_date)?'var(--danger)':'var(--text-muted)' }}">{{ \Carbon\Carbon::parse($a->due_date)->format('d M') }}</td><td><span class="sc-badge badge-info">{{ $a->submissions_count ?? 0 }}</span></td></tr>
            @empty<tr><td colspan="4" class="text-center py-3" style="color:var(--text-muted)">No assignments yet</td></tr>@endforelse
            </tbody></table></div>
        </div>
    </div>
    <div class="col-lg-6 animate-slide-up anim-delay-2">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-megaphone me-2 text-primary-sc"></i>Recent Notices</h5><a href="{{ route('faculty.notices') }}" class="sc-badge badge-primary">View All</a></div>
            <div class="card-body-sc">
                @forelse($recentNotices as $notice)
                <div class="d-flex gap-3 mb-3 pb-3" style="border-bottom:1px solid var(--border)">
                    <div style="width:38px;height:38px;background:{{ $notice->is_important?'rgba(239,68,68,.1)':'var(--primary-light)' }};border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="bi bi-{{ $notice->is_important?'exclamation-circle':'megaphone' }}-fill" style="color:{{ $notice->is_important?'var(--danger)':'var(--primary)' }}"></i></div>
                    <div><div style="font-weight:600;font-size:.875rem">{{ Str::limit($notice->title,42) }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $notice->created_at->diffForHumans() }}</div></div>
                </div>
                @empty<div class="text-center py-3" style="color:var(--text-muted)">No recent notices</div>@endforelse
            </div>
        </div>
    </div>
</div>
@endsection
