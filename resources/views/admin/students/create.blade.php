@extends('layouts.dashboard')
@section('title','Add Student')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Add New Student</h1></div><a href="{{ route('admin.students.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center"><div class="col-lg-9 animate-slide-up">
<div class="dashboard-card"><div class="card-header-sc"><h5><i class="bi bi-person-plus me-2 text-primary-sc"></i>Student Information</h5></div>
<div class="card-body-sc">
<form method="POST" action="{{ route('admin.students.store') }}" data-validate>@csrf
<div class="row g-3">
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Full Name *</label><input type="text" name="name" class="sc-input @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Student full name">@error('name')<div class="form-error">{{ $message }}</div>@enderror</div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Email *</label><input type="email" name="email" class="sc-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="student@email.com">@error('email')<div class="form-error">{{ $message }}</div>@enderror</div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Phone</label><input type="text" name="phone" class="sc-input" value="{{ old('phone') }}" placeholder="10-digit number"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Course *</label><select name="course_id" class="sc-select" required><option value="">Select Course</option>@foreach($courses as $c)<option value="{{ $c->id }}" {{ old('course_id')==$c->id?'selected':'' }}>{{ $c->name }} ({{ $c->department->name ?? '' }})</option>@endforeach</select></div></div>
<div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Batch Year</label><input type="text" name="batch_year" class="sc-input" value="{{ old('batch_year', date('Y').'-'.substr(date('Y')+1,-2)) }}" placeholder="2024-25"></div></div>
<div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Gender</label><select name="gender" class="sc-select"><option value="">Select</option><option value="male">Male</option><option value="female">Female</option><option value="other">Other</option></select></div></div>
<div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Blood Group</label><select name="blood_group" class="sc-select"><option value="">Select</option>@foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)<option value="{{ $bg }}">{{ $bg }}</option>@endforeach</select></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Guardian Name</label><input type="text" name="guardian_name" class="sc-input" value="{{ old('guardian_name') }}" placeholder="Parent/Guardian"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Guardian Phone</label><input type="text" name="guardian_phone" class="sc-input" value="{{ old('guardian_phone') }}"></div></div>
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Address</label><textarea name="address" class="sc-textarea" rows="2" placeholder="Full address">{{ old('address') }}</textarea></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Password *</label><input type="password" name="password" class="sc-input" required placeholder="Minimum 8 characters"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Confirm Password</label><input type="password" name="password_confirmation" class="sc-input" placeholder="Confirm password"></div></div>
</div>
<div class="d-flex gap-2 mt-3"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-circle"></i> Add Student</button><a href="{{ route('admin.students.index') }}" class="btn-outline-sc">Cancel</a></div>
</form></div></div>
</div></div>
@endsection
