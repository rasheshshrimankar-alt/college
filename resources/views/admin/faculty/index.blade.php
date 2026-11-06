@extends('layouts.dashboard')
@section('title','Faculty')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
<div><h1 class="page-title">Faculty Members</h1><p style="color:var(--text-muted);font-size:.875rem">{{ $faculty->total() }} members</p></div>
<a href="{{ route('admin.faculty.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg"></i> Add Faculty</a>
</div>
<div class="dashboard-card mb-4 animate-slide-up"><div class="card-body-sc"><form method="GET" class="row g-2">
<div class="col-md-4"><div class="sc-search-wrapper"><i class="bi bi-search"></i><input type="text" name="search" class="sc-input" placeholder="Search faculty..." value="{{ request('search') }}"></div></div>
<div class="col-md-4"><select name="department" class="sc-select"><option value="">All Departments</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ request('department')==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
<div class="col-md-2"><button type="submit" class="btn-primary-sc btn-sm-sc w-100">Filter</button></div>
<div class="col-md-2"><a href="{{ route('admin.faculty.index') }}" class="btn-outline-sc btn-sm-sc w-100">Clear</a></div>
</form></div></div>
<div class="row g-3">
@forelse($faculty as $i => $f)
<div class="col-md-6 col-lg-4" style="animation:fadeInUp .5s ease {{ $i*0.07 }}s both">
<div class="sc-card" style="padding:1.75rem;text-align:center;transition:all .3s" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
<img src="{{ $f->user->avatar_url }}" style="width:80px;height:80px;border-radius:50%;border:3px solid var(--primary-light);margin-bottom:1rem;object-fit:cover" alt="">
<h5 style="font-weight:700;font-size:.95rem;margin-bottom:.2rem">{{ $f->user->name }}</h5>
<div style="color:var(--primary);font-size:.8rem;font-weight:600;margin-bottom:.2rem">{{ $f->designation }}</div>
<div style="font-size:.78rem;color:var(--text-muted);margin-bottom:.75rem">{{ $f->department->name ?? '-' }}</div>
<div class="d-flex flex-wrap gap-1 justify-content-center mb-3">
<span class="sc-badge badge-secondary" style="font-size:.62rem">{{ $f->faculty_id }}</span>
@if($f->qualification)<span class="sc-badge badge-info" style="font-size:.62rem">{{ Str::limit($f->qualification,18) }}</span>@endif
</div>
<div class="d-flex gap-2 justify-content-center">
<a href="{{ route('admin.faculty.show',$f) }}" class="table-action-btn view"><i class="bi bi-eye"></i></a>
<a href="{{ route('admin.faculty.edit',$f) }}" class="table-action-btn edit"><i class="bi bi-pencil"></i></a>
<form method="POST" action="{{ route('admin.faculty.destroy',$f) }}">@csrf @method('DELETE')<button class="table-action-btn delete" data-confirm="Delete {{ $f->user->name }}?"><i class="bi bi-trash"></i></button></form>
</div>
</div>
</div>
@empty
<div class="col-12"><div class="empty-state"><div class="empty-icon"><i class="bi bi-person-badge"></i></div><h4>No faculty members</h4><a href="{{ route('admin.faculty.create') }}" class="btn-primary-sc mt-3">Add Faculty</a></div></div>
@endforelse
</div>
@if($faculty->hasPages())<div class="mt-3">{{ $faculty->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
@endsection
