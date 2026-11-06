@extends('layouts.dashboard')
@section('title','Edit News')
@section('page_title','Edit News')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><a href="{{ route('admin.news.index') }}">News</a><i class="bi bi-chevron-right"></i><span>Edit</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Edit News</h1></div><a href="{{ route('admin.news.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-8">
    <div class="dashboard-card">
        <div class="card-header-sc"><h5><i class="bi bi-pencil me-2 text-primary-sc"></i>Edit Article</h5></div>
        <div class="card-body-sc">
            <form method="POST" action="{{ route('admin.news.update',$news) }}" enctype="multipart/form-data" data-validate>
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Title *</label><input type="text" name="title" class="sc-input" value="{{ old('title',$news->title) }}" required></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Category</label><select name="category" class="sc-select"><option value="achievement" {{ $news->category=='achievement'?'selected':'' }}>Achievement</option><option value="academic" {{ $news->category=='academic'?'selected':'' }}>Academic</option><option value="industry" {{ $news->category=='industry'?'selected':'' }}>Industry</option><option value="infrastructure" {{ $news->category=='infrastructure'?'selected':'' }}>Infrastructure</option><option value="sports" {{ $news->category=='sports'?'selected':'' }}>Sports</option><option value="general" {{ $news->category=='general'?'selected':'' }}>General</option></select></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Status</label><select name="status" class="sc-select"><option value="published" {{ $news->status=='published'?'selected':'' }}>Published</option><option value="draft" {{ $news->status=='draft'?'selected':'' }}>Draft</option></select></div></div>
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Content</label><textarea name="content" class="sc-input" rows="6" required>{{ old('content',$news->content) }}</textarea></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">New Image (optional)</label><input type="file" name="image" class="sc-input" accept="image/*"></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label" style="display:flex;align-items:center;gap:.5rem;cursor:pointer"><input type="checkbox" name="is_featured" value="1" {{ $news->is_featured?'checked':'' }} style="width:16px;height:16px;accent-color:var(--primary)"> Feature this article</label></div></div>
                </div>
                <div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Update</button><a href="{{ route('admin.news.index') }}" class="btn-outline-sc">Cancel</a></div>
            </form>
        </div>
    </div>
</div></div>
@endsection
