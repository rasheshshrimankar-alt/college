@extends('layouts.dashboard')
@section('title','Edit Course')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Edit Course</h1></div><a href="{{ route('admin.courses.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-8">
<div class="dashboard-card"><div class="card-header-sc"><h5><i class="bi bi-pencil me-2 text-primary-sc"></i>Edit Course</h5></div><div class="card-body-sc">
<form method="POST" action="{{ route('admin.courses.update',$course) }}" data-validate>@csrf @method('PUT')
<div class="row g-3">
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Course Name *</label><input type="text" name="name" class="sc-input" value="{{ old('name',$course->name) }}" required></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Code *</label><input type="text" name="code" class="sc-input" value="{{ old('code',$course->code) }}" required></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Department *</label><select name="department_id" class="sc-select" required><option value="">Select</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ $course->department_id==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div></div>
<div class="col-md-3"><div class="sc-form-group"><label class="sc-label">Duration (Years)</label><input type="number" name="duration_years" class="sc-input" value="{{ old('duration_years',$course->duration_years) }}" min="1"></div></div>
<div class="col-md-3"><div class="sc-form-group"><label class="sc-label">Semesters</label><input type="number" name="total_semesters" class="sc-input" value="{{ old('total_semesters',$course->total_semesters) }}" min="1"></div></div>
<div class="col-md-3"><div class="sc-form-group"><label class="sc-label">Fee/Semester</label><input type="number" name="fees_per_semester" class="sc-input" value="{{ old('fees_per_semester',$course->fees_per_semester) }}"></div></div>
<div class="col-md-3"><div class="sc-form-group"><label class="sc-label">Total Seats</label><input type="number" name="total_seats" class="sc-input" value="{{ old('total_seats',$course->total_seats) }}"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Status</label><select name="status" class="sc-select"><option value="active" {{ $course->status=='active'?'selected':'' }}>Active</option><option value="inactive" {{ $course->status=='inactive'?'selected':'' }}>Inactive</option></select></div></div>
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Description</label><textarea name="description" class="sc-input" rows="3">{{ old('description',$course->description) }}</textarea></div></div>
</div>
<div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Save</button><a href="{{ route('admin.courses.index') }}" class="btn-outline-sc">Cancel</a></div>
</form></div></div></div></div>
@endsection
