@extends('layouts.dashboard')
@section('title','Edit Student')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Edit Student</h1></div><a href="{{ route('admin.students.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-9">
<div class="dashboard-card"><div class="card-header-sc"><h5><i class="bi bi-pencil me-2 text-primary-sc"></i>Edit Student</h5></div><div class="card-body-sc">
<form method="POST" action="{{ route('admin.students.update',$student) }}" data-validate>@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Full Name *</label><input type="text" name="name" class="sc-input" value="{{ old('name',$student->user->name) }}" required></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Email *</label><input type="email" name="email" class="sc-input" value="{{ old('email',$student->user->email) }}" required></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Phone</label><input type="text" name="phone" class="sc-input" value="{{ old('phone',$student->user->phone) }}"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Course *</label><select name="course_id" class="sc-select" required><option value="">Select Course</option>@foreach($courses as $c)<option value="{{ $c->id }}" {{ $student->course_id==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select></div></div>
<div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Semester</label><select name="current_semester" class="sc-select">@for($i=1;$i<=8;$i++)<option value="{{ $i }}" {{ $student->current_semester==$i?'selected':'' }}>Sem {{ $i }}</option>@endfor</select></div></div>
<div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Batch Year</label><input type="text" name="batch_year" class="sc-input" value="{{ old('batch_year',$student->batch_year) }}"></div></div>
<div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Gender</label><select name="gender" class="sc-select"><option value="male" {{ $student->gender=='male'?'selected':'' }}>Male</option><option value="female" {{ $student->gender=='female'?'selected':'' }}>Female</option><option value="other" {{ $student->gender=='other'?'selected':'' }}>Other</option></select></div></div>
<div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Blood Group</label><select name="blood_group" class="sc-select"><option value="">Select</option>@foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)<option value="{{ $bg }}" {{ $student->blood_group==$bg?'selected':'' }}>{{ $bg }}</option>@endforeach</select></div></div>
<div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Guardian Name</label><input type="text" name="guardian_name" class="sc-input" value="{{ old('guardian_name',$student->guardian_name) }}"></div></div>
<div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Guardian Phone</label><input type="text" name="guardian_phone" class="sc-input" value="{{ old('guardian_phone',$student->guardian_phone) }}"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Address</label><textarea name="address" class="sc-input" rows="2">{{ old('address',$student->address) }}</textarea></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Status</label><select name="status" class="sc-select"><option value="active" {{ $student->status=='active'?'selected':'' }}>Active</option><option value="inactive" {{ $student->status=='inactive'?'selected':'' }}>Inactive</option><option value="graduated" {{ $student->status=='graduated'?'selected':'' }}>Graduated</option></select></div></div>
</div>
<div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Save Changes</button><a href="{{ route('admin.students.index') }}" class="btn-outline-sc">Cancel</a></div>
</form></div></div></div></div>
@endsection
