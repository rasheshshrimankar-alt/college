@extends('layouts.dashboard')
@section('title','Add Book')
@section('page_title','Add Book')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><a href="{{ route('admin.library.index') }}">Library</a><i class="bi bi-chevron-right"></i><span>Add</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Add Book</h1></div><a href="{{ route('admin.library.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-8">
    <div class="dashboard-card">
        <div class="card-header-sc"><h5><i class="bi bi-book-fill me-2 text-primary-sc"></i>Book Details</h5></div>
        <div class="card-body-sc">
            <form method="POST" action="{{ route('admin.library.store') }}" data-validate>
                @csrf
                <div class="row g-3">
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Book Title *</label><input type="text" name="title" class="sc-input" value="{{ old('title') }}" required placeholder="Enter book title"></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Author *</label><input type="text" name="author" class="sc-input" value="{{ old('author') }}" required></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">ISBN</label><input type="text" name="isbn" class="sc-input" value="{{ old('isbn') }}" placeholder="e.g. 9780262033848"></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Publisher</label><input type="text" name="publisher" class="sc-input" value="{{ old('publisher') }}"></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Publication Year</label><input type="number" name="publication_year" class="sc-input" value="{{ old('publication_year') }}" min="1900" max="{{ date('Y') }}"></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Category</label><input type="text" name="category" class="sc-input" value="{{ old('category') }}" placeholder="e.g. Computer Science, Mathematics"></div></div>
                    <div class="col-md-3"><div class="sc-form-group"><label class="sc-label">Total Copies *</label><input type="number" name="total_copies" class="sc-input" value="{{ old('total_copies',1) }}" min="1" required></div></div>
                    <div class="col-md-3"><div class="sc-form-group"><label class="sc-label">Location</label><input type="text" name="location" class="sc-input" value="{{ old('location') }}" placeholder="e.g. Rack A-5"></div></div>
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Description</label><textarea name="description" class="sc-input" rows="3">{{ old('description') }}</textarea></div></div>
                </div>
                <div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Add Book</button><a href="{{ route('admin.library.index') }}" class="btn-outline-sc">Cancel</a></div>
            </form>
        </div>
    </div>
</div></div>
@endsection
