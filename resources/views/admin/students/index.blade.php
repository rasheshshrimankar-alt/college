@extends('layouts.dashboard')
@section('title','Students Management')
@section('page_title','Students')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><span>Students</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Students</h1><p style="color:var(--text-muted);font-size:.875rem">Total: {{ $students->total() }} enrolled students</p></div>
    <a href="{{ route('admin.students.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg"></i> Add Student</a>
</div>
<div class="dashboard-card mb-4 animate-slide-up">
    <div class="card-body-sc">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4"><div class="sc-search-wrapper"><i class="bi bi-search"></i><input type="text" name="search" class="sc-input" placeholder="Search name or email..." value="{{ request('search') }}"></div></div>
            <div class="col-md-2"><select name="department" class="sc-select"><option value="">All Depts</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ request('department')==$d->id?'selected':'' }}>{{ $d->code }}</option>@endforeach</select></div>
            <div class="col-md-2"><select name="course" class="sc-select"><option value="">All Courses</option>@foreach($courses as $c)<option value="{{ $c->id }}" {{ request('course')==$c->id?'selected':'' }}>{{ $c->code }}</option>@endforeach</select></div>
            <div class="col-md-2"><select name="status" class="sc-select"><option value="">All Status</option><option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option><option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option></select></div>
            <div class="col-md-2 d-flex gap-2"><button type="submit" class="btn-primary-sc btn-sm-sc flex-fill"><i class="bi bi-search"></i></button><a href="{{ route('admin.students.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-x-lg"></i></a></div>
        </form>
    </div>
</div>
<div class="dashboard-card animate-slide-up anim-delay-2">
    <div class="sc-table-wrapper"><table class="sc-table">
        <thead><tr><th>#</th><th>Student</th><th>ID</th><th>Course</th><th>Sem</th><th>Fees Due</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($students as $i => $student)
        <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
            <td style="color:var(--text-muted);font-size:.78rem">{{ $students->firstItem()+$i }}</td>
            <td><div class="d-flex align-items-center gap-2"><img src="{{ $student->user->avatar_url }}" style="width:34px;height:34px;border-radius:50%;object-fit:cover;border:2px solid var(--primary-light)"><div><div style="font-weight:600;font-size:.85rem">{{ $student->user->name }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $student->user->email }}</div></div></div></td>
            <td><code style="font-size:.75rem;background:var(--primary-light);color:var(--primary);padding:2px 6px;border-radius:4px">{{ $student->student_id }}</code></td>
            <td style="font-size:.82rem">{{ Str::limit($student->course->name ?? '-',22) }}</td>
            <td><span class="sc-badge badge-info">{{ $student->current_semester ?? 1 }}</span></td>
            <td style="font-weight:600;color:{{ $student->fees_due > 0 ? 'var(--danger)' : 'var(--success)' }}">{{ $student->fees_due > 0 ? '₹'.number_format($student->fees_due) : '✓ Clear' }}</td>
            <td><span class="sc-badge {{ $student->status=='active'?'badge-success':'badge-secondary' }}">{{ ucfirst($student->status) }}</span></td>
            <td><div class="d-flex gap-1">
                <a href="{{ route('admin.students.show',$student) }}" class="table-action-btn view"><i class="bi bi-eye"></i></a>
                <a href="{{ route('admin.students.edit',$student) }}" class="table-action-btn edit"><i class="bi bi-pencil"></i></a>
                <form method="POST" action="{{ route('admin.students.destroy',$student) }}" style="display:inline">@csrf @method('DELETE')<button class="table-action-btn delete" data-confirm="Delete {{ $student->user->name }}?"><i class="bi bi-trash"></i></button></form>
            </div></td>
        </tr>
        @empty
        <tr><td colspan="8"><div class="empty-state"><div class="empty-icon"><i class="bi bi-people"></i></div><h4>No students found</h4><a href="{{ route('admin.students.create') }}" class="btn-primary-sc mt-3">Add Student</a></div></td></tr>
        @endforelse
        </tbody>
    </table></div>
    @if($students->hasPages())<div class="card-body-sc pt-0">{{ $students->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
