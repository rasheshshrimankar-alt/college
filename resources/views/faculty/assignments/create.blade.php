@extends('layouts.dashboard')
@section('title','Create Assignment')
@section('page_title','Create Assignment')
@section('breadcrumb')<a href="{{ route('faculty.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><a href="{{ route('faculty.assignments.index') }}">Assignments</a><i class="bi bi-chevron-right"></i><span>Create</span>@endsection
@section('sidebar')@include('faculty.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Create Assignment</h1></div>
    <a href="{{ route('faculty.assignments.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="row justify-content-center animate-slide-up">
    <div class="col-lg-8">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-clipboard-plus me-2 text-primary-sc"></i>New Assignment</h5></div>
            <div class="card-body-sc">
                <form method="POST" action="{{ route('faculty.assignments.store') }}" enctype="multipart/form-data" data-validate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="sc-form-group">
                                <label class="sc-label">Assignment Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="sc-input {{ $errors->has('title')?'is-invalid':'' }}" value="{{ old('title') }}" placeholder="Enter assignment title" required>
                                @error('title')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Subject <span class="text-danger">*</span></label>
                                <select name="subject_id" class="sc-select {{ $errors->has('subject_id')?'is-invalid':'' }}" required>
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $s)<option value="{{ $s->id }}" {{ old('subject_id')==$s->id?'selected':'' }}>{{ $s->name }} ({{ $s->code }})</option>@endforeach
                                </select>
                                @error('subject_id')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Course <span class="text-danger">*</span></label>
                                <select name="course_id" class="sc-select {{ $errors->has('course_id')?'is-invalid':'' }}" required>
                                    <option value="">Select Course</option>
                                    @foreach($courses as $c)<option value="{{ $c->id }}" {{ old('course_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach
                                </select>
                                @error('course_id')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="sc-form-group">
                                <label class="sc-label">Semester</label>
                                <select name="semester" class="sc-select">
                                    @for($i=1;$i<=8;$i++)<option value="{{ $i }}" {{ old('semester')==$i?'selected':'' }}>Semester {{ $i }}</option>@endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="sc-form-group">
                                <label class="sc-label">Max Marks <span class="text-danger">*</span></label>
                                <input type="number" name="max_marks" class="sc-input {{ $errors->has('max_marks')?'is-invalid':'' }}" value="{{ old('max_marks',10) }}" min="1" required>
                                @error('max_marks')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="sc-form-group">
                                <label class="sc-label">Due Date <span class="text-danger">*</span></label>
                                <input type="date" name="due_date" class="sc-input {{ $errors->has('due_date')?'is-invalid':'' }}" value="{{ old('due_date') }}" required>
                                @error('due_date')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="sc-form-group">
                                <label class="sc-label">Description / Instructions</label>
                                <textarea name="description" class="sc-input" rows="4" placeholder="Enter assignment description and instructions...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Create Assignment</button>
                        <a href="{{ route('faculty.assignments.index') }}" class="btn-outline-sc">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
