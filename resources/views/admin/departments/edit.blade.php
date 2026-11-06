@extends('layouts.dashboard')
@section('title','Edit Department')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Edit: {{ $department->name }}</h1></div><a href="{{ route('admin.departments.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center"><div class="col-lg-7 animate-slide-up">
<div class="dashboard-card"><div class="card-header-sc"><h5><i class="bi bi-building me-2 text-primary-sc"></i>Update Department</h5></div><div class="card-body-sc">
<form method="POST" action="{{ route('admin.departments.update',$department) }}">@csrf @method('PUT')
<div class="sc-form-group"><label class="sc-label">Name *</label><input type="text" name="name" class="sc-input" value="{{ old('name',$department->name) }}" required></div>
<div class="sc-form-group"><label class="sc-label">Code *</label><input type="text" name="code" class="sc-input" value="{{ old('code',$department->code) }}" required></div>
<div class="sc-form-group"><label class="sc-label">Description</label><textarea name="description" class="sc-textarea" rows="3">{{ old('description',$department->description) }}</textarea></div>
<div class="row g-3"><div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Head</label><input type="text" name="head_name" class="sc-input" value="{{ old('head_name',$department->head_name) }}"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Status</label><select name="status" class="sc-select"><option value="active" {{ $department->status=='active'?'selected':'' }}>Active</option><option value="inactive" {{ $department->status=='inactive'?'selected':'' }}>Inactive</option></select></div></div></div>
<div class="d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check"></i> Update</button><a href="{{ route('admin.departments.index') }}" class="btn-outline-sc">Cancel</a></div>
</form></div></div></div></div>
@endsection
