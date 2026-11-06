@extends('layouts.dashboard')
@section('title','Edit Faculty')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Edit Faculty</h1></div><a href="{{ route('admin.faculty.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-9">
<div class="dashboard-card"><div class="card-header-sc"><h5><i class="bi bi-pencil me-2 text-primary-sc"></i>Edit Faculty</h5></div><div class="card-body-sc">
<form method="POST" action="{{ route('admin.faculty.update',$faculty) }}" data-validate>@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Full Name *</label><input type="text" name="name" class="sc-input" value="{{ old('name',$faculty->user->name) }}" required></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Email *</label><input type="email" name="email" class="sc-input" value="{{ old('email',$faculty->user->email) }}" required></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Phone</label><input type="text" name="phone" class="sc-input" value="{{ old('phone',$faculty->user->phone) }}"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Department *</label><select name="department_id" class="sc-select" required><option value="">Select</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ $faculty->department_id==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Designation</label><input type="text" name="designation" class="sc-input" value="{{ old('designation',$faculty->designation) }}"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Qualification</label><input type="text" name="qualification" class="sc-input" value="{{ old('qualification',$faculty->qualification) }}"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Specialization</label><input type="text" name="specialization" class="sc-input" value="{{ old('specialization',$faculty->specialization) }}"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Experience</label><input type="text" name="experience" class="sc-input" value="{{ old('experience',$faculty->experience) }}" placeholder="e.g. 10 years"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Salary</label><input type="number" name="salary" class="sc-input" value="{{ old('salary',$faculty->salary) }}"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Status</label><select name="status" class="sc-select"><option value="active" {{ ($faculty->status??'active')=='active'?'selected':'' }}>Active</option><option value="inactive" {{ ($faculty->status??'')=='inactive'?'selected':'' }}>Inactive</option></select></div></div>
</div>
<div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Save Changes</button><a href="{{ route('admin.faculty.index') }}" class="btn-outline-sc">Cancel</a></div>
</form></div></div></div></div>
@endsection
