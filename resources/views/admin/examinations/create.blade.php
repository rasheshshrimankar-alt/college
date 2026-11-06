@extends('layouts.dashboard')
@section('title','Add Examination')
@section('page_title','Add Examination')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><a href="{{ route('admin.examinations.index') }}">Examinations</a><i class="bi bi-chevron-right"></i><span>Add</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Add Examination</h1></div><a href="{{ route('admin.examinations.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-9">
    <div class="dashboard-card">
        <div class="card-header-sc"><h5><i class="bi bi-clipboard-plus me-2 text-primary-sc"></i>Examination Details</h5></div>
        <div class="card-body-sc">
            <form method="POST" action="{{ route('admin.examinations.store') }}" data-validate>
                @csrf
                <div class="row g-3">
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Examination Name *</label><input type="text" name="name" class="sc-input" value="{{ old('name') }}" placeholder="e.g. Mid-Semester Examination 2026" required></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Course *</label><select name="course_id" class="sc-select" required><option value="">Select Course</option>@foreach($courses as $c)<option value="{{ $c->id }}" {{ old('course_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Department *</label><select name="department_id" class="sc-select" required><option value="">Select Department</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ old('department_id')==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div></div>
                    <div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Exam Type *</label><select name="exam_type" class="sc-select" required><option value="internal">Internal</option><option value="external">External (University)</option><option value="mid_semester">Mid-Semester</option><option value="end_semester">End-Semester</option><option value="supplementary">Supplementary</option></select></div></div>
                    <div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Semester *</label><select name="semester" class="sc-select" required>@for($i=1;$i<=8;$i++)<option value="{{ $i }}" {{ old('semester')==$i?'selected':'' }}>Semester {{ $i }}</option>@endfor</select></div></div>
                    <div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Academic Year *</label><input type="text" name="academic_year" class="sc-input" value="{{ old('academic_year',date('Y').'-'.substr(date('Y')+1,-2)) }}" required></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Start Date</label><input type="date" name="start_date" class="sc-input" value="{{ old('start_date') }}"></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">End Date</label><input type="date" name="end_date" class="sc-input" value="{{ old('end_date') }}"></div></div>
                    <div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Total Marks *</label><input type="number" name="total_marks" class="sc-input" value="{{ old('total_marks',100) }}" required min="1"></div></div>
                    <div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Passing Marks *</label><input type="number" name="passing_marks" class="sc-input" value="{{ old('passing_marks',40) }}" required min="1"></div></div>
                    <div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Status</label><select name="status" class="sc-select"><option value="upcoming" selected>Upcoming</option><option value="ongoing">Ongoing</option><option value="completed">Completed</option></select></div></div>
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Description</label><textarea name="description" class="sc-input" rows="3" placeholder="Additional instructions...">{{ old('description') }}</textarea></div></div>
                </div>
                <div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Create Examination</button><a href="{{ route('admin.examinations.index') }}" class="btn-outline-sc">Cancel</a></div>
            </form>
        </div>
    </div>
</div></div>
@endsection
