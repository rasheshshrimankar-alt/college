@extends('layouts.dashboard')
@section('title','My Profile')
@section('sidebar')@include('student.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">My Profile</h1></div></div>
<div class="row g-4">
<div class="col-lg-4 animate-slide-up anim-delay-1">
<div class="dashboard-card text-center"><div class="card-body-sc">
<img src="{{ auth()->user()->avatar_url }}" style="width:100px;height:100px;border-radius:50%;border:4px solid var(--primary-light);margin-bottom:1rem">
<h4 style="font-weight:800;font-size:1.1rem">{{ auth()->user()->name }}</h4>
<div style="color:var(--primary);font-size:.875rem;font-weight:600;margin-bottom:.5rem">{{ $student->course->name ?? '-' }}</div>
<div class="d-flex flex-wrap gap-2 justify-content-center mb-3">
<span class="sc-badge badge-primary">{{ $student->student_id }}</span>
<span class="sc-badge badge-info">Sem {{ $student->current_semester ?? 1 }}</span>
<span class="sc-badge badge-success">{{ ucfirst($student->status) }}</span>
</div>
<div style="text-align:left;border-top:1px solid var(--border);padding-top:1rem">
@foreach([['bi-envelope','Email',auth()->user()->email],['bi-phone','Phone',auth()->user()->phone??'N/A'],['bi-building','Department',$student->department->name??'-'],['bi-mortarboard','Batch',$student->batch_year??'-'],['bi-droplet','Blood Group',$student->blood_group??'N/A'],['bi-people','Guardian',$student->guardian_name??'N/A']] as [$icon,$label,$val])
<div class="d-flex gap-2 mb-2"><i class="bi {{ $icon }}" style="color:var(--primary);margin-top:2px;flex-shrink:0"></i><div><span style="font-size:.72rem;color:var(--text-muted);display:block">{{ $label }}</span><span style="font-size:.85rem;font-weight:500">{{ $val }}</span></div></div>
@endforeach
</div>
</div></div>
</div>
<div class="col-lg-8 animate-slide-up anim-delay-2">
<div class="dashboard-card"><div class="card-header-sc"><h5><i class="bi bi-pencil-square me-2 text-primary-sc"></i>Update Profile</h5></div><div class="card-body-sc">
<form method="POST" action="{{ route('student.profile.update') }}" data-validate>@csrf @method('PATCH')
<div class="row g-3">
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Full Name (read-only)</label><input type="text" class="sc-input" value="{{ auth()->user()->name }}" disabled style="background:var(--bg)"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Email (read-only)</label><input type="text" class="sc-input" value="{{ auth()->user()->email }}" disabled style="background:var(--bg)"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Phone Number *</label><input type="text" name="phone" class="sc-input" value="{{ old('phone',auth()->user()->phone) }}" required></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Blood Group</label><select name="blood_group" class="sc-select"><option value="">Select</option>@foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)<option value="{{ $bg }}" {{ $student->blood_group==$bg?'selected':'' }}>{{ $bg }}</option>@endforeach</select></div></div>
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Address</label><textarea name="address" class="sc-input" rows="3" placeholder="Enter your full address">{{ old('address',$student->address) }}</textarea></div></div>
</div>
<div class="mt-3"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Update Profile</button></div>
</form>
</div></div>
</div>
</div>
@endsection
