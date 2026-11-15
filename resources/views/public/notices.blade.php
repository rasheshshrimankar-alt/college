@extends('layouts.public')
@section('title', 'College Notices')
@section('meta_description', 'Read the latest official notices and announcements from SMART CAMPUS College of Technology.')

@section('content')
<section class="section-padding" style="padding-top:3rem">
    <div class="container-xl">
        <div class="section-header text-center">
            <div class="section-label">Announcements</div>
            <h1 class="section-title">Latest <span class="gradient-text">Notices</span></h1>
            <p class="section-desc">Official announcements, academic updates and important information for our college community.</p>
        </div>

        <div class="row g-4">
            @forelse($notices as $notice)
                <div class="col-12">
                    <article class="sc-card" style="padding:1.5rem">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                            <span class="sc-badge badge-primary">{{ ucfirst($notice->category ?? 'General') }}</span>
                            @if($notice->is_important)
                                <span class="sc-badge badge-danger"><i class="bi bi-exclamation-circle me-1"></i>Important</span>
                            @endif
                        </div>
                        <h2 style="font-size:1.15rem;font-weight:700">{{ $notice->title }}</h2>
                        <div class="mb-3" style="font-size:.85rem;color:var(--text-muted)">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $notice->publish_date ? $notice->publish_date->format('d M Y') : optional($notice->created_at)->format('d M Y') }}
                            @if($notice->target)
                                <span class="ms-3"><i class="bi bi-people me-1"></i>{{ ucfirst($notice->target) }}</span>
                            @endif
                        </div>
                        <div style="color:var(--text-muted);white-space:normal">{{ $notice->content }}</div>
                        @if($notice->expiry_date)
                            <div class="mt-3" style="font-size:.8rem;color:var(--text-muted)">Valid until: {{ $notice->expiry_date->format('d M Y') }}</div>
                        @endif
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="sc-card text-center p-5">
                        <i class="bi bi-megaphone" style="font-size:2.5rem;color:var(--primary)"></i>
                        <h3 class="mt-3">No notices available</h3>
                        <p style="color:var(--text-muted)">New college announcements will appear here.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($notices->hasPages())
            <div class="mt-4">{{ $notices->withQueryString()->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
</section>
@endsection
