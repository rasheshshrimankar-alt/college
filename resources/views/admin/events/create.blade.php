@extends('layouts.dashboard')
@section('title','Add Event')
@section('page_title','Add Event')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><a href="{{ route('admin.events.index') }}">Events</a><i class="bi bi-chevron-right"></i><span>Add</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Add Event</h1></div><a href="{{ route('admin.events.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-8">
    <div class="dashboard-card">
        <div class="card-header-sc"><h5><i class="bi bi-calendar-plus me-2 text-primary-sc"></i>Event Details</h5></div>
        <div class="card-body-sc">
            <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" data-validate>
                @csrf
                <div class="row g-3">
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Event Title *</label><input type="text" name="title" class="sc-input" value="{{ old('title') }}" required></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Category *</label><select name="category" class="sc-select" required><option value="">Select</option><option value="technical">Technical</option><option value="cultural">Cultural</option><option value="sports">Sports</option><option value="academic">Academic</option><option value="placement">Placement</option><option value="alumni">Alumni</option><option value="other">Other</option></select></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Status</label><select name="status" class="sc-select"><option value="upcoming" selected>Upcoming</option><option value="ongoing">Ongoing</option><option value="completed">Completed</option><option value="cancelled">Cancelled</option></select></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Start Date & Time *</label><input type="datetime-local" name="start_datetime" class="sc-input" value="{{ old('start_datetime') }}" required></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">End Date & Time</label><input type="datetime-local" name="end_datetime" class="sc-input" value="{{ old('end_datetime') }}"></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Venue</label><input type="text" name="venue" class="sc-input" value="{{ old('venue') }}" placeholder="e.g. Main Auditorium"></div></div>
                    <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Organizer</label><input type="text" name="organizer" class="sc-input" value="{{ old('organizer') }}" placeholder="e.g. Student Council"></div></div>
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Description</label><textarea name="description" class="sc-input" rows="4" placeholder="Event description...">{{ old('description') }}</textarea></div></div>
                    <div class="col-12"><div class="sc-form-group"><label class="sc-label">Event Image</label><input type="file" name="image" class="sc-input" accept="image/*"></div></div>
                </div>
                <div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Create Event</button><a href="{{ route('admin.events.index') }}" class="btn-outline-sc">Cancel</a></div>
            </form>
        </div>
    </div>
</div></div>
@endsection
