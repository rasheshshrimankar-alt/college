@extends('layouts.dashboard')
@section('title','Admission Detail')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
<div><h1 class="page-title">{{ $admission->application_number }}</h1><span class="sc-badge badge-{{ $admission->status=='approved'?'success':($admission->status=='rejected'?'danger':'warning') }}">{{ ucfirst($admission->status) }}</span></div>
<a href="{{ route('admin.admissions.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a>
</div>
<div class="row g-3">
<div class="col-lg-8 animate-slide-up anim-delay-1">
<div class="dashboard-card"><div class="card-header-sc"><h5>Applicant Details</h5></div><div class="card-body-sc">
<div class="row g-3">
@foreach([['Full Name',$admission->applicant_name],['Email',$admission->applicant_email],['Phone',$admission->applicant_phone],['Course',$admission->course->name ?? '-'],['Qualification',$admission->previous_qualification],['Guardian',$admission->guardian_name ?? '-'],['Guardian Phone',$admission->guardian_phone ?? '-'],['Academic Year',$admission->academic_year]] as [$label,$val])
<div class="col-md-6"><small style="color:var(--text-muted);font-size:.72rem;text-transform:uppercase;letter-spacing:.5px">{{ $label }}</small><div style="font-weight:600;margin-top:.15rem">{{ $val }}</div></div>
@endforeach
<div class="col-md-6"><small style="color:var(--text-muted);font-size:.72rem;text-transform:uppercase">Academic %</small><div style="font-size:1.8rem;font-weight:900;color:{{ $admission->previous_percentage>=75?'var(--success)':($admission->previous_percentage>=60?'var(--warning)':'var(--danger)') }}">{{ number_format($admission->previous_percentage,2) }}%</div></div>
@if($admission->address)<div class="col-12"><small style="color:var(--text-muted);font-size:.72rem;text-transform:uppercase">Address</small><div style="font-weight:500;margin-top:.15rem">{{ $admission->address }}</div></div>@endif
@if($admission->remarks)<div class="col-12"><div class="sc-alert info"><i class="bi bi-info-circle"></i> <strong>Remarks:</strong> {{ $admission->remarks }}</div></div>@endif
</div>
</div></div>
</div>
<div class="col-lg-4 animate-slide-up anim-delay-2">
<div class="dashboard-card mb-3"><div class="card-header-sc"><h5>Update Status</h5></div><div class="card-body-sc">
<form method="POST" action="{{ route('admin.admissions.update-status',$admission) }}">@csrf @method('PATCH')
<div class="sc-form-group"><label class="sc-label">Status</label><select name="status" class="sc-select"><option value="pending" {{ $admission->status=='pending'?'selected':'' }}>Pending</option><option value="approved" {{ $admission->status=='approved'?'selected':'' }}>Approved</option><option value="rejected" {{ $admission->status=='rejected'?'selected':'' }}>Rejected</option><option value="waitlisted" {{ $admission->status=='waitlisted'?'selected':'' }}>Waitlisted</option></select></div>
<div class="sc-form-group"><label class="sc-label">Remarks</label><textarea name="remarks" class="sc-textarea" rows="3" placeholder="Optional remarks...">{{ $admission->remarks }}</textarea></div>
<button type="submit" class="btn-primary-sc w-100"><i class="bi bi-check-circle"></i> Update Status</button>
</form></div></div>
<div class="dashboard-card text-center"><div class="card-body-sc">
<div style="font-size:3rem;font-weight:900;color:{{ $admission->previous_percentage>=75?'var(--success)':($admission->previous_percentage>=60?'var(--warning)':'var(--danger)') }}">{{ number_format($admission->previous_percentage,1) }}%</div>
<div style="font-size:.8rem;color:var(--text-muted)">Academic Score</div>
<div class="sc-progress mt-2 mb-2"><div class="sc-progress-bar" style="width:{{ min($admission->previous_percentage,100) }}%"></div></div>
<div style="font-size:.78rem;color:var(--text-muted)">Applied {{ $admission->created_at->diffForHumans() }}</div>
</div></div>
</div>
</div>
@endsection
