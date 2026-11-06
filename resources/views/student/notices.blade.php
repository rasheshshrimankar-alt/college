@extends('layouts.dashboard')
@section('title','Notices')
@section('page_title','Notices')
@section('breadcrumb')<a href="{{ route('student.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Notices</span>@endsection
@section('sidebar')@include('student.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Notices & Announcements</h1><p style="color:var(--text-muted);font-size:.875rem">Stay updated with all college notices</p></div>
</div>

<div class="dashboard-card animate-slide-up">
    <div class="card-body-sc">
        @forelse($notices as $i => $notice)
        <div class="d-flex gap-3 mb-4 pb-4" style="border-bottom:1px solid var(--border);animation:fadeInLeft .5s ease {{ $i*0.06 }}s both">
            <div style="min-width:52px;height:60px;background:{{ $notice->is_important?'rgba(239,68,68,.12)':'var(--gradient-1)' }};border-radius:12px;display:flex;flex-direction:column;align-items:center;justify-content:center;color:{{ $notice->is_important?'var(--danger)':'white' }};font-weight:700">
                <span style="font-size:.58rem;text-transform:uppercase">{{ $notice->publish_date ? \Carbon\Carbon::parse($notice->publish_date)->format('M') : $notice->created_at->format('M') }}</span>
                <span style="font-size:1.1rem">{{ $notice->publish_date ? \Carbon\Carbon::parse($notice->publish_date)->format('d') : $notice->created_at->format('d') }}</span>
            </div>
            <div class="flex-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <h5 style="font-weight:700;font-size:.95rem;margin:0">{{ $notice->title }}</h5>
                    @if($notice->is_important)<span class="sc-badge badge-danger" style="font-size:.65rem">IMPORTANT</span>@endif
                    <span class="sc-badge badge-secondary" style="font-size:.65rem">{{ ucfirst($notice->category ?? 'general') }}</span>
                </div>
                <p style="font-size:.85rem;color:var(--text-muted);margin-bottom:.5rem">{{ Str::limit($notice->content,200) }}</p>
                <div style="font-size:.75rem;color:var(--text-muted)"><i class="bi bi-clock me-1"></i>{{ $notice->created_at->diffForHumans() }}</div>
            </div>
        </div>
        @empty
        <div class="empty-state py-5">
            <div class="empty-icon"><i class="bi bi-megaphone"></i></div>
            <h4>No notices found</h4>
            <p>There are no active notices at the moment.</p>
        </div>
        @endforelse
    </div>
    @if($notices->hasPages())
    <div class="card-body-sc pt-0">{{ $notices->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
