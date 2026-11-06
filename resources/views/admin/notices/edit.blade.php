@extends('layouts.dashboard')
@section('title','Edit Notice')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Edit Notice</h1></div><a href="{{ route('admin.notices.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-8">
<div class="dashboard-card"><div class="card-header-sc"><h5><i class="bi bi-pencil me-2 text-primary-sc"></i>Edit Notice</h5></div><div class="card-body-sc">
<form method="POST" action="{{ route('admin.notices.update',$notice) }}" data-validate>@csrf @method('PUT')
<div class="row g-3">
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Title *</label><input type="text" name="title" class="sc-input" value="{{ old('title',$notice->title) }}" required></div></div>
<div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Category</label><select name="category" class="sc-select"><option value="general" {{ $notice->category=='general'?'selected':'' }}>General</option><option value="exam" {{ $notice->category=='exam'?'selected':'' }}>Examination</option><option value="fee" {{ $notice->category=='fee'?'selected':'' }}>Fee</option><option value="event" {{ $notice->category=='event'?'selected':'' }}>Event</option><option value="holiday" {{ $notice->category=='holiday'?'selected':'' }}>Holiday</option></select></div></div>
<div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Target</label><select name="target" class="sc-select"><option value="all" {{ $notice->target=='all'?'selected':'' }}>All</option><option value="students" {{ $notice->target=='students'?'selected':'' }}>Students</option><option value="faculty" {{ $notice->target=='faculty'?'selected':'' }}>Faculty</option></select></div></div>
<div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Status</label><select name="status" class="sc-select"><option value="active" {{ $notice->status=='active'?'selected':'' }}>Active</option><option value="inactive" {{ $notice->status=='inactive'?'selected':'' }}>Inactive</option></select></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Publish Date</label><input type="date" name="publish_date" class="sc-input" value="{{ old('publish_date',$notice->publish_date) }}"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Expiry Date</label><input type="date" name="expiry_date" class="sc-input" value="{{ old('expiry_date',$notice->expiry_date) }}"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label" style="display:flex;align-items:center;gap:.5rem;cursor:pointer"><input type="checkbox" name="is_important" value="1" {{ $notice->is_important?'checked':'' }} style="width:16px;height:16px;accent-color:var(--danger)"> Mark as Important</label></div></div>
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Content *</label><textarea name="content" class="sc-input" rows="5" required>{{ old('content',$notice->content) }}</textarea></div></div>
</div>
<div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Update</button><a href="{{ route('admin.notices.index') }}" class="btn-outline-sc">Cancel</a></div>
</form></div></div></div></div>
@endsection
