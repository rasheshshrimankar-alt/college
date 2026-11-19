@extends('layouts.dashboard')
@section('title','Raise Complaint')
@section('page_title','Raise Complaint')
@section('breadcrumb')<a href="{{ route('student.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><a href="{{ route('student.complaints.index') }}">Complaints</a><i class="bi bi-chevron-right"></i><span>New</span>@endsection
@section('sidebar')@include('student.partials.sidebar')@endsection
@section('content')
<div class="page-header"><div><h1 class="page-title">Raise a Complaint</h1><p class="text-muted mb-0">Describe your issue clearly so the college team can help.</p></div><a href="{{ route('student.complaints.index') }}" class="btn-outline-sc btn-sm-sc">Back</a></div>
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="dashboard-card"><div class="card-body-sc"><form method="POST" action="{{ route('student.complaints.store') }}">@csrf
<div class="sc-form-group mb-3"><label class="sc-label" for="subject">Subject</label><input id="subject" name="subject" class="sc-input" maxlength="255" value="{{ old('subject') }}" required>@error('subject')<small class="text-danger">{{ $message }}</small>@enderror</div>
<div class="row g-3"><div class="col-md-6"><label class="sc-label" for="category">Category</label><select id="category" name="category" class="sc-select w-100" required>@foreach(['academic'=>'Academic','fees'=>'Fees','facilities'=>'Facilities','hostel'=>'Hostel','technical'=>'Technical','other'=>'Other'] as $value=>$label)<option value="{{ $value }}" @selected(old('category','academic')===$value)>{{ $label }}</option>@endforeach</select></div><div class="col-md-6"><label class="sc-label" for="priority">Priority</label><select id="priority" name="priority" class="sc-select w-100" required>@foreach(['low'=>'Low','medium'=>'Medium','high'=>'High'] as $value=>$label)<option value="{{ $value }}" @selected(old('priority','medium')===$value)>{{ $label }}</option>@endforeach</select></div></div>
<div class="sc-form-group mt-3 mb-3"><label class="sc-label" for="description">Description</label><textarea id="description" name="description" class="sc-input" rows="6" minlength="20" maxlength="5000" required>{{ old('description') }}</textarea><small class="text-muted">Please provide at least 20 characters.</small></div>
<button type="submit" class="btn-primary-sc"><i class="bi bi-send me-2"></i>Submit Complaint</button>
</form></div></div>
@endsection
