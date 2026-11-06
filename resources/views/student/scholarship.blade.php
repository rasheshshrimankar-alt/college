@extends('layouts.dashboard')
@section('title','Scholarships')
@section('page_title','Scholarships')
@section('breadcrumb')<a href="{{ route('student.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Scholarships</span>@endsection
@section('sidebar')@include('student.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Scholarships</h1><p style="color:var(--text-muted);font-size:.875rem">Explore available scholarships</p></div>
</div>

<div class="row g-3">
    @forelse($scholarships as $i => $s)
    <div class="col-md-6 col-lg-4 animate-slide-up" style="animation-delay:{{ $i*0.1 }}s">
        <div class="sc-card h-100" style="padding:1.5rem">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div style="width:50px;height:50px;background:var(--gradient-1);border-radius:12px;display:flex;align-items:center;justify-content:center;color:white;font-size:1.4rem"><i class="bi bi-award"></i></div>
                <span class="sc-badge badge-success" style="font-size:.7rem">Active</span>
            </div>
            <h5 style="font-weight:700;font-size:.95rem;margin-bottom:.4rem">{{ $s->name }}</h5>
            <p style="font-size:.82rem;color:var(--text-muted);margin-bottom:1rem">{{ Str::limit($s->description,100) }}</p>
            <div class="d-flex justify-content-between align-items-center mb-3" style="border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:.75rem 0">
                <div><div style="font-size:.72rem;color:var(--text-muted)">Amount</div><div style="font-size:1.2rem;font-weight:800;color:var(--success)">₹{{ number_format($s->amount) }}/yr</div></div>
                <div class="text-end"><div style="font-size:.72rem;color:var(--text-muted)">Provider</div><div style="font-size:.85rem;font-weight:600">{{ $s->provider }}</div></div>
            </div>
            @if($s->eligibility)
            <div style="font-size:.78rem;color:var(--text-muted);margin-bottom:.75rem"><i class="bi bi-check-circle me-1 text-success"></i><strong>Eligibility:</strong> {{ $s->eligibility }}</div>
            @endif
            @if($s->application_deadline)
            <div style="font-size:.78rem;color:{{ now()->gt($s->application_deadline)?'var(--danger)':'var(--text-muted)' }}">
                <i class="bi bi-calendar me-1"></i>Deadline: {{ \Carbon\Carbon::parse($s->application_deadline)->format('d M Y') }}
                @if(now()->gt($s->application_deadline))<span class="sc-badge badge-danger ms-1" style="font-size:.6rem">Closed</span>@endif
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="dashboard-card">
            <div class="empty-state py-5">
                <div class="empty-icon"><i class="bi bi-award"></i></div>
                <h4>No scholarships available</h4>
                <p>Check back later for new scholarship announcements</p>
            </div>
        </div>
    </div>
    @endforelse
</div>
@endsection
