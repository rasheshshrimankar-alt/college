@extends('layouts.dashboard')
@section('title','Edit Book')
@section('page_title','Edit Book')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><a href="{{ route('admin.library.index') }}">Library</a><i class="bi bi-chevron-right"></i><span>Edit</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Edit Book</h1></div><a href="{{ route('admin.library.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-8">
    <div class="dashboard-card">
        <div class="card-header-sc"><h5><i class="bi bi-pencil me-2 text-primary-sc"></i>Edit Book</h5></div>
        <div class="card-body-sc">
            <form method="POST" action="{{ route('admin.library.update', $libraryBook) }}" data-validate>
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Title *</label><input type="text" name="title" class="sc-input" value="{{ old('title',$libraryBook->title) }}" required></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Author *</label><input type="text" name="author" class="sc-input" value="{{ old('author',$libraryBook->author) }}" required></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">ISBN</label><input type="text" name="isbn" class="sc-input" value="{{ old('isbn',$libraryBook->isbn) }}"></div></div>
                    <div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Category</label><input type="text" name="category" class="sc-input" value="{{ old('category',$libraryBook->category) }}"></div></div>
                    <div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Total Copies</label><input type="number" name="total_copies" class="sc-input" value="{{ old('total_copies',$libraryBook->total_copies) }}" min="1" required></div></div>
                    <div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Status</label><select name="status" class="sc-select"><option value="available" {{ $libraryBook->status=='available'?'selected':'' }}>Available</option><option value="unavailable" {{ $libraryBook->status=='unavailable'?'selected':'' }}>Unavailable</option></select></div></div>
                </div>
                <div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Save Changes</button><a href="{{ route('admin.library.index') }}" class="btn-outline-sc">Cancel</a></div>
            </form>
        </div>
    </div>
</div></div>
@endsection
