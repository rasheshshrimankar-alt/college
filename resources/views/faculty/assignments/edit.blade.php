@extends('layouts.dashboard')
@section('title','Edit Assignment')
@section('page_title','Edit Assignment')
@section('breadcrumb')<a href="{{ route('faculty.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><a href="{{ route('faculty.assignments.index') }}">Assignments</a><i class="bi bi-chevron-right"></i><span>Edit</span>@endsection
@section('sidebar')@include('faculty.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Edit Assignment</h1></div>
    <a href="{{ route('faculty.assignments.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="row justify-content-center animate-slide-up">
    <div class="col-lg-8">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-pencil me-2 text-primary-sc"></i>Edit Assignment</h5></div>
            <div class="card-body-sc">
                <form method="POST" action="{{ route('faculty.assignments.update', $assignment) }}" data-validate>
                    @csrf @method('PATCH')
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="sc-form-group">
                                <label class="sc-label">Assignment Title</label>
                                <input type="text" name="title" class="sc-input" value="{{ old('title', $assignment->title) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Max Marks</label>
                                <input type="number" name="max_marks" class="sc-input" value="{{ old('max_marks', $assignment->max_marks ?? $assignment->total_marks) }}" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Due Date</label>
                                <input type="date" name="due_date" class="sc-input" value="{{ old('due_date', $assignment->due_date?->format('Y-m-d')) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Status</label>
                                <select name="status" class="sc-select">
                                    <option value="active" {{ $assignment->status=='active'?'selected':'' }}>Active</option>
                                    <option value="inactive" {{ $assignment->status=='inactive'?'selected':'' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="sc-form-group">
                                <label class="sc-label">Description</label>
                                <textarea name="description" class="sc-input" rows="4">{{ old('description', $assignment->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Save Changes</button>
                        <a href="{{ route('faculty.assignments.index') }}" class="btn-outline-sc">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
