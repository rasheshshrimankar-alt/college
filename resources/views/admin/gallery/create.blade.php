@extends('layouts.dashboard')
@section('title','Add Photo')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Add Gallery Photo</h1></div><a href="{{ route('admin.gallery.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-7">
<div class="dashboard-card"><div class="card-header-sc"><h5><i class="bi bi-image me-2 text-primary-sc"></i>Upload Photo</h5></div><div class="card-body-sc">
<form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" data-validate>@csrf
<div class="row g-3">
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Title *</label><input type="text" name="title" class="sc-input" value="{{ old('title') }}" required></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Category</label><select name="category" class="sc-select"><option value="campus">Campus</option><option value="events">Events</option><option value="labs">Labs</option><option value="sports">Sports</option><option value="cultural">Cultural</option><option value="academic">Academic</option><option value="library">Library</option></select></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label" style="display:flex;align-items:center;gap:.5rem;cursor:pointer"><input type="checkbox" name="is_featured" value="1" style="width:16px;height:16px;accent-color:var(--primary)"> Feature on homepage</label></div></div>
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Image *</label><input type="file" name="image" class="sc-input" accept="image/*" required></div></div>
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Description</label><textarea name="description" class="sc-input" rows="2">{{ old('description') }}</textarea></div></div>
</div>
<div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-cloud-upload me-2"></i>Upload</button><a href="{{ route('admin.gallery.index') }}" class="btn-outline-sc">Cancel</a></div>
</form></div></div></div></div>
@endsection
