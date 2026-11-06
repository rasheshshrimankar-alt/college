@extends('layouts.dashboard')
@section('title','Courses')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Courses <span class="sc-badge badge-primary ms-2">{{ $courses->total() }}</span></h1></div><a href="{{ route('admin.courses.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg"></i> Add Course</a></div>
<div class="dashboard-card mb-4 animate-slide-up"><div class="card-body-sc"><form method="GET" class="row g-2">
<div class="col-md-5"><div class="sc-search-wrapper"><i class="bi bi-search"></i><input type="text" name="search" class="sc-input" placeholder="Search courses..." value="{{ request('search') }}"></div></div>
<div class="col-md-4"><select name="department" class="sc-select"><option value="">All Departments</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ request('department')==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
<div class="col-md-3 d-flex gap-2"><button type="submit" class="btn-primary-sc btn-sm-sc flex-fill">Filter</button><a href="{{ route('admin.courses.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-x"></i></a></div>
</form></div></div>
<div class="dashboard-card animate-slide-up anim-delay-2"><div class="sc-table-wrapper"><table class="sc-table">
<thead><tr><th>Course</th><th>Code</th><th>Department</th><th>Duration</th><th>Fee/Sem</th><th>Seats</th><th>Status</th><th>Actions</th></tr></thead>
<tbody>@forelse($courses as $i => $c)
<tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
<td style="font-weight:600;font-size:.875rem">{{ $c->name }}</td>
<td><code style="font-size:.75rem;background:var(--primary-light);color:var(--primary);padding:2px 6px;border-radius:4px">{{ $c->code }}</code></td>
<td style="font-size:.82rem">{{ $c->department->name ?? '-' }}</td>
<td><span class="sc-badge badge-info">{{ $c->duration_years }}y / {{ $c->total_semesters }}sem</span></td>
<td style="font-weight:700;color:var(--primary)">₹{{ number_format($c->fees_per_semester) }}</td>
<td>{{ $c->total_seats }}</td>
<td><span class="sc-badge {{ $c->status=='active'?'badge-success':'badge-secondary' }}">{{ ucfirst($c->status) }}</span></td>
<td><div class="d-flex gap-1"><a href="{{ route('admin.courses.edit',$c) }}" class="table-action-btn edit"><i class="bi bi-pencil"></i></a><form method="POST" action="{{ route('admin.courses.destroy',$c) }}" style="display:inline">@csrf @method('DELETE')<button class="table-action-btn delete" data-confirm="Delete {{ $c->name }}?"><i class="bi bi-trash"></i></button></form></div></td>
</tr>
@empty<tr><td colspan="8"><div class="empty-state"><div class="empty-icon"><i class="bi bi-book"></i></div><h4>No courses</h4><a href="{{ route('admin.courses.create') }}" class="btn-primary-sc mt-3">Add Course</a></div></td></tr>@endforelse</tbody>
</table></div>@if($courses->hasPages())<div class="card-body-sc pt-0">{{ $courses->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif</div>
@endsection
