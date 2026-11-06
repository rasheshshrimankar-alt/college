@extends('layouts.dashboard')
@section('title','Add Department')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Add Department</h1></div><a href="{{ route('admin.departments.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center"><div class="col-lg-7 animate-slide-up">
<div class="dashboard-card"><div class="card-header-sc"><h5><i class="bi bi-building me-2 text-primary-sc"></i>Department Details</h5></div><div class="card-body-sc">
<form method="POST" action="{{ route('admin.departments.store') }}" data-validate>@csrf
<div class="sc-form-group"><label class="sc-label">Department Name *</label><input type="text" name="name" class="sc-input" value="{{ old('name') }}" required placeholder="e.g. Computer Science & Engineering"></div>
<div class="sc-form-group"><label class="sc-label">Code *</label><input type="text" name="code" class="sc-input" value="{{ old('code') }}" required placeholder="e.g. CSE"></div>
<div class="sc-form-group"><label class="sc-label">Description</label><textarea name="description" class="sc-textarea" rows="3" placeholder="Brief overview...">{{ old('description') }}</textarea></div>
<div class="row g-3"><div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Head of Department</label><input type="text" name="head_name" class="sc-input" value="{{ old('head_name') }}" placeholder="Name"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Established Year</label><input type="number" name="established_year" class="sc-input" value="{{ old('established_year') }}" placeholder="1995"></div></div></div>
<div class="d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check"></i> Create</button><a href="{{ route('admin.departments.index') }}" class="btn-outline-sc">Cancel</a></div>
</form></div></div></div></div>
@endsection
