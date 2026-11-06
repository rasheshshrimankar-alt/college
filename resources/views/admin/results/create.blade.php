@extends('layouts.dashboard')
@section('title','Add Result')
@section('page_title','Add Result')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><a href="{{ route('admin.results.index') }}">Results</a><i class="bi bi-chevron-right"></i><span>Add</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Add Result</h1></div><a href="{{ route('admin.results.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-7">
    <div class="dashboard-card">
        <div class="card-header-sc"><h5><i class="bi bi-graph-up me-2 text-primary-sc"></i>Result Entry</h5></div>
        <div class="card-body-sc">
            <form method="POST" action="{{ route('admin.results.store') }}" data-validate>
                @csrf
                <div class="row g-3">
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Student *</label><select name="student_id" class="sc-select" required><option value="">Select Student</option>@foreach($students as $s)<option value="{{ $s->id }}" {{ old('student_id')==$s->id?'selected':'' }}>{{ $s->user->name ?? '' }} ({{ $s->student_id }})</option>@endforeach</select></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Examination *</label><select name="examination_id" class="sc-select" required><option value="">Select Examination</option>@foreach($examinations as $e)<option value="{{ $e->id }}" {{ old('examination_id')==$e->id?'selected':'' }}>{{ $e->name }}</option>@endforeach</select></div></div>
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Subject *</label><select name="subject_id" class="sc-select" required><option value="">Select Subject</option>@foreach($subjects as $s)<option value="{{ $s->id }}" {{ old('subject_id')==$s->id?'selected':'' }}>{{ $s->name }} ({{ $s->code }})</option>@endforeach</select></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Marks Obtained *</label><input type="number" name="marks_obtained" class="sc-input" value="{{ old('marks_obtained') }}" min="0" step="0.5" required></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Total Marks *</label><input type="number" name="total_marks" class="sc-input" value="{{ old('total_marks',100) }}" min="1" required></div></div>
                </div>
                <div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Save Result</button><a href="{{ route('admin.results.index') }}" class="btn-outline-sc">Cancel</a></div>
            </form>
        </div>
    </div>
</div></div>
@endsection
