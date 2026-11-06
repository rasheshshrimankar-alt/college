@extends('layouts.dashboard')
@section('title','Departments')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Departments</h1></div><a href="{{ route('admin.departments.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg"></i> Add Department</a></div>
<div class="row g-3">
@forelse($departments as $i => $dept)
<div class="col-md-6 col-lg-4" style="animation:fadeInUp .5s ease {{ $i*0.07 }}s both">
<div class="sc-card dept-card" style="transition:all .3s" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
<div class="dept-icon"><i class="bi bi-building-fill"></i></div>
<h4>{{ $dept->name }}</h4><div class="dept-badge mb-2">{{ $dept->code }}</div>
<p>{{ Str::limit($dept->description,'',75) }}</p>
<div class="d-flex justify-content-around mt-3" style="border-top:1px solid var(--border);padding-top:1rem">
<div class="text-center"><div style="font-size:1.3rem;font-weight:800;color:var(--primary)">{{ $dept->courses_count }}</div><div style="font-size:.7rem;color:var(--text-muted)">Courses</div></div>
<div class="text-center"><div style="font-size:1.3rem;font-weight:800;color:var(--secondary)">{{ $dept->faculty_count }}</div><div style="font-size:.7rem;color:var(--text-muted)">Faculty</div></div>
<div class="text-center"><div style="font-size:1.3rem;font-weight:800;color:var(--success)">{{ $dept->students_count }}</div><div style="font-size:.7rem;color:var(--text-muted)">Students</div></div>
</div>
@if($dept->head_name)<div style="font-size:.78rem;color:var(--text-muted);margin-top:.75rem"><i class="bi bi-person-fill me-1"></i>HOD: {{ $dept->head_name }}</div>@endif
<div class="d-flex gap-2 justify-content-center mt-3">
<a href="{{ route('admin.departments.edit',$dept) }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-pencil"></i> Edit</a>
<form method="POST" action="{{ route('admin.departments.destroy',$dept) }}" style="display:inline">@csrf @method('DELETE')<button class="table-action-btn delete" data-confirm="Delete {{ $dept->name }}?"><i class="bi bi-trash"></i></button></form>
</div>
</div></div>
@empty<div class="col-12"><div class="empty-state"><div class="empty-icon"><i class="bi bi-building"></i></div><h4>No departments</h4><a href="{{ route('admin.departments.create') }}" class="btn-primary-sc mt-3">Create First</a></div></div>@endforelse
</div>
@endsection
