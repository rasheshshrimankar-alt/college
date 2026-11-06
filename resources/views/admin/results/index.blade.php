@extends('layouts.dashboard')
@section('title','Results')
@section('page_title','Results')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><span>Results</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Results Management</h1><p style="color:var(--text-muted);font-size:.875rem">{{ $results->total() }} result entries</p></div>
    <a href="{{ route('admin.results.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg"></i> Add Result</a>
</div>
<div class="dashboard-card mb-4 animate-slide-up">
    <div class="card-body-sc">
        <form method="GET" class="row g-2"><div class="col-md-4"><select name="examination_id" class="sc-select" onchange="this.form.submit()"><option value="">All Examinations</option>@foreach($examinations as $e)<option value="{{ $e->id }}" {{ request('examination_id')==$e->id?'selected':'' }}>{{ $e->name }}</option>@endforeach</select></div><div class="col-md-2"><a href="{{ route('admin.results.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-x-lg"></i></a></div></form>
    </div>
</div>
<div class="dashboard-card animate-slide-up anim-delay-2">
    <div class="sc-table-wrapper"><table class="sc-table">
        <thead><tr><th>#</th><th>Student</th><th>Examination</th><th>Subject</th><th>Marks</th><th>%</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($results as $i => $r)
        <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
            <td style="color:var(--text-muted);font-size:.78rem">{{ $results->firstItem()+$i }}</td>
            <td><div style="font-weight:600;font-size:.875rem">{{ $r->student->user->name ?? '-' }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $r->student->student_id ?? '' }}</div></td>
            <td style="font-size:.8rem">{{ Str::limit($r->examination->name ?? '-',30) }}</td>
            <td style="font-size:.82rem">{{ $r->subject->name ?? '-' }}</td>
            <td style="font-weight:700">{{ $r->marks_obtained }}<span style="font-weight:400;color:var(--text-muted)">/{{ $r->total_marks }}</span></td>
            <td><span style="font-weight:700;color:{{ $r->percentage>=60?'var(--success)':($r->percentage>=40?'var(--warning)':'var(--danger)') }}">{{ number_format($r->percentage,1) }}%</span></td>
            <td><span class="sc-badge {{ $r->status=='pass'?'badge-success':'badge-danger' }}">{{ ucfirst($r->status) }}</span></td>
            <td><form method="POST" action="{{ route('admin.results.destroy',$r) }}" style="display:inline">@csrf @method('DELETE')<button class="table-action-btn delete" data-confirm="Delete this result?"><i class="bi bi-trash"></i></button></form></td>
        </tr>
        @empty<tr><td colspan="8"><div class="empty-state"><div class="empty-icon"><i class="bi bi-graph-up"></i></div><h4>No results</h4><a href="{{ route('admin.results.create') }}" class="btn-primary-sc mt-3">Add Result</a></div></td></tr>@endforelse
        </tbody>
    </table></div>
    @if($results->hasPages())<div class="card-body-sc pt-0">{{ $results->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
