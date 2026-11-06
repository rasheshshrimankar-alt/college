@extends('layouts.dashboard')
@section('title','Add Course')
@section('page_title','Add Course')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><a href="{{ route('admin.courses.index') }}">Courses</a><i class="bi bi-chevron-right"></i><span>Add</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Add Course</h1></div><a href="{{ route('admin.courses.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-8">
    <div class="dashboard-card">
        <div class="card-header-sc"><h5><i class="bi bi-book-fill me-2 text-primary-sc"></i>Course Details</h5></div>
        <div class="card-body-sc">
            <form method="POST" action="{{ route('admin.courses.store') }}" data-validate>
                @csrf
                <div class="row g-3">
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Course Name *</label><input type="text" name="name" class="sc-input {{ $errors->has('name')?'is-invalid':'' }}" value="{{ old('name') }}" required placeholder="e.g. B.Tech Computer Science"></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Course Code *</label><input type="text" name="code" class="sc-input {{ $errors->has('code')?'is-invalid':'' }}" value="{{ old('code') }}" required placeholder="e.g. BTECH-CS"></div>@error('code')<div class="form-error">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Department *</label><select name="department_id" class="sc-select" required><option value="">Select</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ old('department_id')==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div></div>
                    <div class="col-md-3"><div class="sc-form-group"><label class="sc-label">Duration (Years) *</label><input type="number" name="duration_years" class="sc-input" value="{{ old('duration_years',4) }}" min="1" max="6" required></div></div>
                    <div class="col-md-3"><div class="sc-form-group"><label class="sc-label">Total Semesters *</label><input type="number" name="total_semesters" class="sc-input" value="{{ old('total_semesters',8) }}" min="1" required></div></div>
                    <div class="col-md-3"><div class="sc-form-group"><label class="sc-label">Fees/Semester (₹) *</label><input type="number" name="fees_per_semester" class="sc-input" value="{{ old('fees_per_semester') }}" min="0" required></div></div>
                    <div class="col-md-3"><div class="sc-form-group"><label class="sc-label">Total Seats *</label><input type="number" name="total_seats" class="sc-input" value="{{ old('total_seats',60) }}" min="1" required></div></div>
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Description</label><textarea name="description" class="sc-input" rows="3" placeholder="Brief course description...">{{ old('description') }}</textarea></div></div>
                </div>
                <div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Create Course</button><a href="{{ route('admin.courses.index') }}" class="btn-outline-sc">Cancel</a></div>
            </form>
        </div>
    </div>
</div></div>
@endsection
