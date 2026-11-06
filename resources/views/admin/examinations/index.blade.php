@extends('layouts.dashboard')
@section('title','Examinations')
@section('page_title','Examinations')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><span>Examinations</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Examinations</h1><p style="color:var(--text-muted);font-size:.875rem">{{ $examinations->total() }} total examinations</p></div>
    <a href="{{ route('admin.examinations.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg"></i> Add Exam</a>
</div>
<div class="dashboard-card mb-4 animate-slide-up">
    <div class="card-body-sc">
        <form method="GET" class="row g-2"><div class="col-md-4"><select name="status" class="sc-select" onchange="this.form.submit()"><option value="">All Status</option><option value="upcoming" {{ request('status')=='upcoming'?'selected':'' }}>Upcoming</option><option value="ongoing" {{ request('status')=='ongoing'?'selected':'' }}>Ongoing</option><option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option></select></div><div class="col-md-2"><a href="{{ route('admin.examinations.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-x-lg"></i></a></div></form>
    </div>
</div>
<div class="dashboard-card animate-slide-up anim-delay-2">
    <div class="sc-table-wrapper"><table class="sc-table">
        <thead><tr><th>#</th><th>Examination</th><th>Course</th><th>Type</th><th>Semester</th><th>Dates</th><th>Marks</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($examinations as $i => $exam)
        <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
            <td style="color:var(--text-muted);font-size:.78rem">{{ $examinations->firstItem()+$i }}</td>
            <td><div style="font-weight:600;font-size:.875rem">{{ $exam->name }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $exam->academic_year }}</div></td>
            <td style="font-size:.82rem">{{ $exam->course->name ?? '-' }}</td>
            <td><span class="sc-badge badge-info">{{ ucfirst($exam->exam_type) }}</span></td>
            <td style="font-size:.82rem">Sem {{ $exam->semester }}</td>
            <td style="font-size:.78rem">{{ $exam->start_date ? \Carbon\Carbon::parse($exam->start_date)->format('d M Y') : '-' }}<br><span style="color:var(--text-muted)">to {{ $exam->end_date ? \Carbon\Carbon::parse($exam->end_date)->format('d M Y') : '-' }}</span></td>
            <td style="font-size:.82rem"><span style="font-weight:700">{{ $exam->total_marks }}</span> / Pass: {{ $exam->passing_marks }}</td>
            <td><span class="sc-badge {{ $exam->status=='upcoming'?'badge-primary':($exam->status=='completed'?'badge-success':'badge-warning') }}">{{ ucfirst($exam->status) }}</span></td>
            <td><div class="d-flex gap-1">
                <a href="{{ route('admin.examinations.results',$exam) }}" class="table-action-btn view" title="Results"><i class="bi bi-graph-up"></i></a>
                <a href="{{ route('admin.examinations.edit',$exam) }}" class="table-action-btn edit"><i class="bi bi-pencil"></i></a>
                <form method="POST" action="{{ route('admin.examinations.destroy',$exam) }}" style="display:inline">@csrf @method('DELETE')<button class="table-action-btn delete" data-confirm="Delete this exam?"><i class="bi bi-trash"></i></button></form>
            </div></td>
        </tr>
        @empty
        <tr><td colspan="9"><div class="empty-state"><div class="empty-icon"><i class="bi bi-clipboard2-x"></i></div><h4>No examinations</h4><a href="{{ route('admin.examinations.create') }}" class="btn-primary-sc mt-3">Add Examination</a></div></td></tr>
        @endforelse
        </tbody>
    </table></div>
    @if($examinations->hasPages())<div class="card-body-sc pt-0">{{ $examinations->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
