@extends('layouts.dashboard')
@section('title','Post Notice')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Post Notice</h1></div><a href="{{ route('admin.notices.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center"><div class="col-lg-8 animate-slide-up">
<div class="dashboard-card"><div class="card-header-sc"><h5><i class="bi bi-megaphone me-2 text-primary-sc"></i>Notice Details</h5></div><div class="card-body-sc">
<form method="POST" action="{{ route('admin.notices.store') }}" data-validate>@csrf
<div class="sc-form-group"><label class="sc-label">Notice Title *</label><input type="text" name="title" class="sc-input" value="{{ old('title') }}" required placeholder="e.g. Exam Schedule Released"></div>
<div class="row g-3">
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Category *</label><select name="category" class="sc-select" required><option value="">Select</option><option value="exam">Exam</option><option value="fee">Fee</option><option value="event">Event</option><option value="holiday">Holiday</option><option value="general">General</option><option value="admission">Admission</option></select></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Publish Date *</label><input type="date" name="publish_date" class="sc-input" value="{{ old('publish_date', date('Y-m-d')) }}" required></div></div>
</div>
<div class="sc-form-group"><label class="sc-label">Content *</label><textarea name="content" class="sc-textarea" rows="5" required placeholder="Notice content...">{{ old('content') }}</textarea></div>
<div class="row g-3">
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Expiry Date</label><input type="date" name="expiry_date" class="sc-input" value="{{ old('expiry_date') }}"></div></div>
<div class="col-md-3"><div class="sc-form-group"><label class="sc-label">Status</label><select name="status" class="sc-select"><option value="active">Active</option><option value="inactive">Inactive</option></select></div></div>
<div class="col-md-3 d-flex align-items-end"><div class="sc-form-group w-100"><label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.875rem;color:var(--text);padding:.6rem 0"><input type="checkbox" name="is_important" value="1" {{ old('is_important')?'checked':'' }} style="width:18px;height:18px;accent-color:var(--danger)"> Mark Important</label></div></div>
</div>
<div class="d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-send"></i> Post Notice</button><a href="{{ route('admin.notices.index') }}" class="btn-outline-sc">Cancel</a></div>
</form></div></div></div></div>
@endsection
