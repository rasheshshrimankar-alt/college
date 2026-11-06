@extends('layouts.dashboard')
@section('title','Study Materials')
@section('page_title','Study Materials')
@section('breadcrumb')<a href="{{ route('student.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Study Materials</span>@endsection
@section('sidebar')@include('student.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Study Materials</h1><p style="color:var(--text-muted);font-size:.875rem">Download resources shared by your faculty</p></div>
</div>

<div class="row g-3">
    @forelse($materials as $i => $m)
    <div class="col-md-6 col-lg-4 animate-slide-up" style="animation-delay:{{ $i*0.06 }}s">
        <div class="sc-card" style="padding:1.25rem">
            <div class="d-flex align-items-start gap-3 mb-3">
                @php $typeIcons = ['pdf'=>['bi-file-pdf','#EF4444'],'video'=>['bi-play-circle','#3B82F6'],'ppt'=>['bi-file-ppt','#F59E0B'],'doc'=>['bi-file-word','#2563EB'],'link'=>['bi-link-45deg','#7856D8'],'other'=>['bi-file-zip','#64748B']]; $icon = $typeIcons[$m->type ?? 'other'] ?? ['bi-file-text','#64748B']; @endphp
                <div style="width:44px;height:44px;border-radius:10px;background:{{ $icon[1] }}18;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="bi {{ $icon[0] }}" style="font-size:1.3rem;color:{{ $icon[1] }}"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h6 style="font-weight:700;font-size:.9rem;margin-bottom:.2rem;color:var(--text)">{{ $m->title }}</h6>
                    <div style="font-size:.75rem;color:var(--text-muted)">{{ $m->subject->name ?? 'General' }}</div>
                </div>
                <span class="sc-badge badge-secondary" style="font-size:.62rem">{{ strtoupper($m->type ?? 'FILE') }}</span>
            </div>
            @if($m->description)<p style="font-size:.8rem;color:var(--text-muted);margin-bottom:.75rem">{{ Str::limit($m->description,80) }}</p>@endif
            <div class="d-flex justify-content-between align-items-center" style="border-top:1px solid var(--border);padding-top:.75rem">
                <div style="font-size:.72rem;color:var(--text-muted)"><i class="bi bi-download me-1"></i>{{ $m->download_count ?? 0 }} downloads</div>
                @if($m->file_path)
                <a href="{{ asset('uploads/materials/'.$m->file_path) }}" target="_blank" class="btn-primary-sc btn-sm-sc" style="font-size:.75rem">
                    <i class="bi bi-download"></i> Download
                </a>
                @elseif($m->file_url)
                <a href="{{ $m->file_url }}" target="_blank" class="btn-outline-sc btn-sm-sc" style="font-size:.75rem">
                    <i class="bi bi-box-arrow-up-right"></i> Open Link
                </a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="dashboard-card">
            <div class="empty-state py-5">
                <div class="empty-icon"><i class="bi bi-file-earmark-x"></i></div>
                <h4>No materials available</h4>
                <p>Your faculty hasn't uploaded any study materials yet</p>
            </div>
        </div>
    </div>
    @endforelse
</div>
@if($materials->hasPages())
<div class="mt-3">{{ $materials->links('pagination::bootstrap-5') }}</div>
@endif
@endsection
