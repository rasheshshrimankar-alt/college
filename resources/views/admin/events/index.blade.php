@extends('layouts.dashboard')
@section('title','Events')
@section('page_title','Events')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><span>Events</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Events Management</h1><p style="color:var(--text-muted);font-size:.875rem">Total: {{ $events->total() }} events</p></div>
    <a href="{{ route('admin.events.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg"></i> Add Event</a>
</div>
<div class="dashboard-card mb-4 animate-slide-up">
    <div class="card-body-sc">
        <form method="GET" class="row g-2">
            <div class="col-md-5"><div class="sc-search-wrapper"><i class="bi bi-search"></i><input type="text" name="search" class="sc-input" placeholder="Search events..." value="{{ request('search') }}"></div></div>
            <div class="col-md-3"><select name="status" class="sc-select"><option value="">All Status</option><option value="upcoming" {{ request('status')=='upcoming'?'selected':'' }}>Upcoming</option><option value="ongoing" {{ request('status')=='ongoing'?'selected':'' }}>Ongoing</option><option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option></select></div>
            <div class="col-md-2 d-flex gap-2"><button type="submit" class="btn-primary-sc btn-sm-sc flex-fill"><i class="bi bi-search"></i></button><a href="{{ route('admin.events.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-x-lg"></i></a></div>
        </form>
    </div>
</div>
<div class="dashboard-card animate-slide-up anim-delay-2">
    <div class="sc-table-wrapper"><table class="sc-table">
        <thead><tr><th>#</th><th>Event</th><th>Date</th><th>Venue</th><th>Category</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($events as $i => $e)
        <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
            <td style="color:var(--text-muted);font-size:.78rem">{{ $events->firstItem()+$i }}</td>
            <td><div style="font-weight:600;font-size:.875rem">{{ $e->title }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $e->organizer }}</div></td>
            <td style="font-size:.82rem">{{ $e->start_datetime->format('d M Y') }}<br><span style="font-size:.7rem;color:var(--text-muted)">{{ $e->start_datetime->format('h:i A') }}</span></td>
            <td style="font-size:.82rem;color:var(--text-muted)"><i class="bi bi-geo-alt me-1"></i>{{ Str::limit($e->venue,25) }}</td>
            <td><span class="sc-badge badge-secondary">{{ ucfirst($e->category) }}</span></td>
            <td><span class="sc-badge {{ $e->status=='upcoming'?'badge-primary':($e->status=='ongoing'?'badge-success':'badge-secondary') }}">{{ ucfirst($e->status) }}</span></td>
            <td><div class="d-flex gap-1">
                <a href="{{ route('admin.events.edit',$e) }}" class="table-action-btn edit"><i class="bi bi-pencil"></i></a>
                <form method="POST" action="{{ route('admin.events.destroy',$e) }}" style="display:inline">@csrf @method('DELETE')<button class="table-action-btn delete" data-confirm="Delete this event?"><i class="bi bi-trash"></i></button></form>
            </div></td>
        </tr>
        @empty
        <tr><td colspan="7"><div class="empty-state"><div class="empty-icon"><i class="bi bi-calendar-x"></i></div><h4>No events</h4><a href="{{ route('admin.events.create') }}" class="btn-primary-sc mt-3">Add Event</a></div></td></tr>
        @endforelse
        </tbody>
    </table></div>
    @if($events->hasPages())<div class="card-body-sc pt-0">{{ $events->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
