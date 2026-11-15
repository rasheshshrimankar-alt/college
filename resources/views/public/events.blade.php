@extends('layouts.public')
@section('title', 'Campus Events')
@section('meta_description', 'Explore upcoming and past events at SMART CAMPUS College of Technology.')

@section('content')
<section class="section-padding" style="padding-top:3rem">
    <div class="container-xl">
        <div class="section-header text-center">
            <div class="section-label">Campus Life</div>
            <h1 class="section-title">Campus <span class="gradient-text">Events</span></h1>
            <p class="section-desc">Discover academic, cultural, technical and sports events happening at our campus.</p>
        </div>

        <form method="GET" action="{{ route('events') }}" class="d-flex justify-content-center gap-2 mb-4 flex-wrap">
            <select name="status" class="sc-select" style="max-width:220px">
                <option value="">All events</option>
                <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <button type="submit" class="btn-primary-sc">Filter Events</button>
            <a href="{{ route('events') }}" class="btn-outline-sc">Clear</a>
        </form>

        <div class="row g-4">
            @forelse($events as $event)
                <div class="col-md-6 col-lg-4">
                    <article class="sc-card h-100" style="padding:1.5rem">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                            <span class="sc-badge badge-primary">{{ ucfirst($event->category ?? 'General') }}</span>
                            <span class="sc-badge badge-secondary">{{ ucfirst($event->status ?? 'Scheduled') }}</span>
                        </div>
                        <h3 style="font-size:1.15rem;font-weight:700">{{ $event->title }}</h3>
                        @if($event->start_datetime)
                            <p class="mb-2" style="color:var(--primary);font-weight:600">
                                <i class="bi bi-calendar-event me-2"></i>{{ $event->start_datetime->format('d M Y, h:i A') }}
                            </p>
                        @endif
                        @if($event->venue)
                            <p class="mb-2" style="color:var(--text-muted)"><i class="bi bi-geo-alt me-2"></i>{{ $event->venue }}</p>
                        @endif
                        @if($event->description)
                            <p style="color:var(--text-muted)">{{ \Illuminate\Support\Str::limit(strip_tags($event->description), 180) }}</p>
                        @endif
                        @if($event->organizer)
                            <p class="mb-0" style="font-size:.85rem"><strong>Organized by:</strong> {{ $event->organizer }}</p>
                        @endif
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="sc-card text-center p-5">
                        <i class="bi bi-calendar-event" style="font-size:2.5rem;color:var(--primary)"></i>
                        <h3 class="mt-3">No events to display</h3>
                        <p style="color:var(--text-muted)">Please check again later for campus events.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($events->hasPages())
            <div class="mt-4">{{ $events->withQueryString()->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
</section>
@endsection
