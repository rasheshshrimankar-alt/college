@extends('layouts.dashboard')
@section('title','Edit Event')
@section('page_title','Edit Event')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><a href="{{ route('admin.events.index') }}">Events</a><i class="bi bi-chevron-right"></i><span>Edit</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Edit Event</h1></div><a href="{{ route('admin.events.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-8">
    <div class="dashboard-card">
        <div class="card-header-sc"><h5><i class="bi bi-pencil me-2 text-primary-sc"></i>Edit Event</h5></div>
        <div class="card-body-sc">
            <form method="POST" action="{{ route('admin.events.update',$event) }}" enctype="multipart/form-data" data-validate>
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Event Title *</label><input type="text" name="title" class="sc-input" value="{{ old('title',$event->title) }}" required></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Category</label><select name="category" class="sc-select"><option value="technical" {{ $event->category=='technical'?'selected':'' }}>Technical</option><option value="cultural" {{ $event->category=='cultural'?'selected':'' }}>Cultural</option><option value="sports" {{ $event->category=='sports'?'selected':'' }}>Sports</option><option value="academic" {{ $event->category=='academic'?'selected':'' }}>Academic</option><option value="placement" {{ $event->category=='placement'?'selected':'' }}>Placement</option><option value="alumni" {{ $event->category=='alumni'?'selected':'' }}>Alumni</option><option value="other" {{ $event->category=='other'?'selected':'' }}>Other</option></select></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Status</label><select name="status" class="sc-select"><option value="upcoming" {{ $event->status=='upcoming'?'selected':'' }}>Upcoming</option><option value="ongoing" {{ $event->status=='ongoing'?'selected':'' }}>Ongoing</option><option value="completed" {{ $event->status=='completed'?'selected':'' }}>Completed</option><option value="cancelled" {{ $event->status=='cancelled'?'selected':'' }}>Cancelled</option></select></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Start Date & Time</label><input type="datetime-local" name="start_datetime" class="sc-input" value="{{ old('start_datetime',$event->start_datetime->format('Y-m-d\TH:i')) }}" required></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">End Date & Time</label><input type="datetime-local" name="end_datetime" class="sc-input" value="{{ old('end_datetime',$event->end_datetime?$event->end_datetime->format('Y-m-d\TH:i'):'') }}"></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Venue</label><input type="text" name="venue" class="sc-input" value="{{ old('venue',$event->venue) }}"></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Organizer</label><input type="text" name="organizer" class="sc-input" value="{{ old('organizer',$event->organizer) }}"></div></div>
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Description</label><textarea name="description" class="sc-input" rows="4">{{ old('description',$event->description) }}</textarea></div></div>
                </div>
                <div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Save Changes</button><a href="{{ route('admin.events.index') }}" class="btn-outline-sc">Cancel</a></div>
            </form>
        </div>
    </div>
</div></div>
@endsection
