@extends('layouts.dashboard')
@section('title','Add News')
@section('page_title','Add News')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><a href="{{ route('admin.news.index') }}">News</a><i class="bi bi-chevron-right"></i><span>Add</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Add News</h1></div><a href="{{ route('admin.news.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-8">
    <div class="dashboard-card">
        <div class="card-header-sc"><h5><i class="bi bi-newspaper me-2 text-primary-sc"></i>Article Details</h5></div>
        <div class="card-body-sc">
            <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" data-validate>
                @csrf
                <div class="row g-3">
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Title *</label><input type="text" name="title" class="sc-input" value="{{ old('title') }}" required></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Category *</label><select name="category" class="sc-select" required><option value="">Select</option><option value="achievement">Achievement</option><option value="academic">Academic</option><option value="industry">Industry</option><option value="infrastructure">Infrastructure</option><option value="sports">Sports</option><option value="cultural">Cultural</option><option value="general">General</option></select></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Status</label><select name="status" class="sc-select"><option value="published" selected>Published</option><option value="draft">Draft</option></select></div></div>
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Content *</label><textarea name="content" class="sc-input" rows="6" required placeholder="Write news content here...">{{ old('content') }}</textarea></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Image</label><input type="file" name="image" class="sc-input" accept="image/*"></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label" style="display:flex;align-items:center;gap:.5rem"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured')?'checked':'' }} style="width:16px;height:16px;accent-color:var(--primary)"> Feature this article</label></div></div>
                </div>
                <div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Publish News</button><a href="{{ route('admin.news.index') }}" class="btn-outline-sc">Cancel</a></div>
            </form>
        </div>
    </div>
</div></div>
@endsection
