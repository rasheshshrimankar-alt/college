@extends('layouts.dashboard')
@section('title','Add Faculty')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Add Faculty Member</h1></div><a href="{{ route('admin.faculty.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center"><div class="col-lg-9 animate-slide-up">
<div class="dashboard-card"><div class="card-header-sc"><h5><i class="bi bi-person-badge me-2 text-primary-sc"></i>Faculty Information</h5></div><div class="card-body-sc">
<form method="POST" action="{{ route('admin.faculty.store') }}" data-validate>@csrf
<div class="row g-3">
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Full Name *</label><input type="text" name="name" class="sc-input" value="{{ old('name') }}" required placeholder="Faculty full name"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Email *</label><input type="email" name="email" class="sc-input" value="{{ old('email') }}" required placeholder="faculty@smartcampus.edu"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Phone *</label><input type="text" name="phone" class="sc-input" value="{{ old('phone') }}" required></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Department *</label><select name="department_id" class="sc-select" required><option value="">Select Department</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ old('department_id')==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Designation *</label><select name="designation" class="sc-select" required><option value="">Select</option>@foreach(['Professor','Associate Professor','Assistant Professor','Lecturer','Visiting Faculty','HOD'] as $des)<option value="{{ $des }}" {{ old('designation')==$des?'selected':'' }}>{{ $des }}</option>@endforeach</select></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Qualification *</label><input type="text" name="qualification" class="sc-input" value="{{ old('qualification') }}" placeholder="Ph.D / M.Tech / M.Sc" required></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Specialization</label><input type="text" name="specialization" class="sc-input" value="{{ old('specialization') }}" placeholder="Area of expertise"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Experience</label><input type="text" name="experience" class="sc-input" value="{{ old('experience') }}" placeholder="e.g. 10 years"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Joining Date</label><input type="date" name="joining_date" class="sc-input" value="{{ old('joining_date') }}"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Salary (₹/month)</label><input type="number" name="salary" class="sc-input" value="{{ old('salary') }}" placeholder="0"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Gender</label><select name="gender" class="sc-select"><option value="">Select</option><option value="male">Male</option><option value="female">Female</option><option value="other">Other</option></select></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Password *</label><input type="password" name="password" class="sc-input" required placeholder="Minimum 8 characters"></div></div>
</div>
<div class="d-flex gap-2 mt-3"><button type="submit" class="btn-primary-sc"><i class="bi bi-check"></i> Add Faculty</button><a href="{{ route('admin.faculty.index') }}" class="btn-outline-sc">Cancel</a></div>
</form></div></div></div></div>
@endsection
