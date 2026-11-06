@extends('layouts.dashboard')
@section('title','Edit Scholarship')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Edit Scholarship</h1></div><a href="{{ route('admin.scholarships.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-8">
<div class="dashboard-card"><div class="card-header-sc"><h5><i class="bi bi-pencil me-2 text-primary-sc"></i>Edit Scholarship</h5></div><div class="card-body-sc">
<form method="POST" action="{{ route('admin.scholarships.update',$scholarship) }}" data-validate>@csrf @method('PUT')
<div class="row g-3">
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Name *</label><input type="text" name="name" class="sc-input" value="{{ old('name',$scholarship->name) }}" required></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Provider</label><input type="text" name="provider" class="sc-input" value="{{ old('provider',$scholarship->provider) }}"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Amount (₹)</label><input type="number" name="amount" class="sc-input" value="{{ old('amount',$scholarship->amount) }}"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Deadline</label><input type="date" name="application_deadline" class="sc-input" value="{{ old('application_deadline',$scholarship->application_deadline) }}"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Status</label><select name="status" class="sc-select"><option value="active" {{ $scholarship->status=='active'?'selected':'' }}>Active</option><option value="inactive" {{ $scholarship->status=='inactive'?'selected':'' }}>Inactive</option></select></div></div>
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Eligibility</label><input type="text" name="eligibility" class="sc-input" value="{{ old('eligibility',$scholarship->eligibility) }}"></div></div>
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Description</label><textarea name="description" class="sc-input" rows="3">{{ old('description',$scholarship->description) }}</textarea></div></div>
</div>
<div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Save</button><a href="{{ route('admin.scholarships.index') }}" class="btn-outline-sc">Cancel</a></div>
</form></div></div></div></div>
@endsection
