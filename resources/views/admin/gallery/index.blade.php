@extends('layouts.dashboard')
@section('title','Gallery')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Gallery Management</h1><p style="color:var(--text-muted);font-size:.875rem">{{ $gallery->total() }} photos</p></div><a href="{{ route('admin.gallery.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg"></i> Add Photo</a></div>
<div class="dashboard-card mb-4 animate-slide-up"><div class="card-body-sc"><form method="GET" class="d-flex gap-2 flex-wrap"><select name="category" class="sc-select" style="width:auto" onchange="this.form.submit()"><option value="">All Categories</option>@foreach($categories as $cat)<option value="{{ $cat }}" {{ request('category')==$cat?'selected':'' }}>{{ ucfirst($cat) }}</option>@endforeach</select><a href="{{ route('admin.gallery.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-x-lg"></i></a></form></div></div>
<div class="row g-3 animate-slide-up anim-delay-2">
@forelse($gallery as $i => $item)
<div class="col-md-4 col-lg-3" style="animation:fadeInLeft .4s ease {{ $i*0.05 }}s both">
<div class="sc-card" style="overflow:hidden">
<div style="position:relative;height:180px;overflow:hidden">
@if($item->image_path && file_exists(public_path('uploads/gallery/'.$item->image_path)))
<img src="{{ asset('uploads/gallery/'.$item->image_path) }}" style="width:100%;height:100%;object-fit:cover;transition:transform .3s" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
@else
<div style="width:100%;height:100%;background:var(--gradient-1);display:flex;align-items:center;justify-content:center;color:white;font-size:2rem"><i class="bi bi-image"></i></div>
@endif
@if($item->is_featured)<span style="position:absolute;top:.5rem;left:.5rem" class="sc-badge badge-warning"><i class="bi bi-star-fill"></i> Featured</span>@endif
</div>
<div style="padding:1rem">
<div style="font-weight:600;font-size:.875rem;margin-bottom:.25rem">{{ $item->title }}</div>
<div class="d-flex justify-content-between align-items-center">
<span class="sc-badge badge-info" style="font-size:.65rem">{{ ucfirst($item->category) }}</span>
<form method="POST" action="{{ route('admin.gallery.destroy',$item) }}" style="display:inline">@csrf @method('DELETE')<button class="table-action-btn delete" data-confirm="Delete photo?"><i class="bi bi-trash"></i></button></form>
</div>
</div>
</div>
</div>
@empty
<div class="col-12"><div class="empty-state py-5"><div class="empty-icon"><i class="bi bi-images"></i></div><h4>No photos yet</h4><a href="{{ route('admin.gallery.create') }}" class="btn-primary-sc mt-3">Add Photo</a></div></div>
@endforelse
</div>
@if($gallery->hasPages())<div class="mt-3">{{ $gallery->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
@endsection
