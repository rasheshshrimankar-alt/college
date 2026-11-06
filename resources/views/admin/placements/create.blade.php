@extends('layouts.dashboard')
@section('title','Add Placement')
@section('page_title','Add Placement')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><a href="{{ route('admin.placements.index') }}">Placements</a><i class="bi bi-chevron-right"></i><span>Add</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Add Placement</h1></div><a href="{{ route('admin.placements.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-8">
    <div class="dashboard-card">
        <div class="card-header-sc"><h5><i class="bi bi-briefcase me-2 text-primary-sc"></i>Placement Details</h5></div>
        <div class="card-body-sc">
            <form method="POST" action="{{ route('admin.placements.store') }}" data-validate>
                @csrf
                <div class="row g-3">
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Student *</label><select name="student_id" class="sc-select" required><option value="">Select Student</option>@foreach($students as $s)<option value="{{ $s->id }}" {{ old('student_id')==$s->id?'selected':'' }}>{{ $s->user->name ?? '' }} ({{ $s->student_id }})</option>@endforeach</select></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Company Name *</label><input type="text" name="company_name" class="sc-input" value="{{ old('company_name') }}" required></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Position *</label><input type="text" name="position" class="sc-input" value="{{ old('position') }}" required placeholder="e.g. Software Engineer"></div></div>
                    <div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Package (LPA)</label><input type="number" name="package_lpa" class="sc-input" value="{{ old('package_lpa') }}" step="0.1" min="0" placeholder="e.g. 8.5"></div></div>
                    <div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Placement Type</label><select name="placement_type" class="sc-select"><option value="campus">Campus</option><option value="off_campus">Off-Campus</option><option value="internship">Internship</option></select></div></div>
                    <div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Academic Year *</label><input type="text" name="academic_year" class="sc-input" value="{{ old('academic_year',date('Y').'-'.substr(date('Y')+1,-2)) }}" required></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Offer Date</label><input type="date" name="offer_date" class="sc-input" value="{{ old('offer_date') }}"></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Status</label><select name="status" class="sc-select"><option value="offered">Offered</option><option value="joined">Joined</option><option value="declined">Declined</option></select></div></div>
                </div>
                <div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Add Placement</button><a href="{{ route('admin.placements.index') }}" class="btn-outline-sc">Cancel</a></div>
            </form>
        </div>
    </div>
</div></div>
@endsection
