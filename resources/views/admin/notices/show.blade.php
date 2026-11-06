@extends('layouts.dashboard')
@section('title','View Notice')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Notice Details</h1></div><div class="d-flex gap-2"><a href="{{ route('admin.notices.edit',$notice) }}" class="btn-primary-sc btn-sm-sc"><i class="bi bi-pencil"></i> Edit</a><a href="{{ route('admin.notices.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div></div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-8">
<div class="dashboard-card"><div class="card-body-sc">
<div class="d-flex gap-2 mb-3">
<span class="sc-badge badge-secondary">{{ ucfirst($notice->category) }}</span>
<span class="sc-badge badge-info">{{ ucfirst($notice->target) }}</span>
@if($notice->is_important)<span class="sc-badge badge-danger"><i class="bi bi-exclamation-triangle me-1"></i>Important</span>@endif
<span class="sc-badge {{ $notice->status=='active'?'badge-success':'badge-secondary' }}">{{ ucfirst($notice->status) }}</span>
</div>
<h2 style="font-weight:800;font-size:1.3rem;margin-bottom:1rem;color:var(--text)">{{ $notice->title }}</h2>
<p style="font-size:.9rem;line-height:1.8;color:var(--text-muted)">{{ $notice->content }}</p>
<hr style="border-color:var(--border);margin:1.5rem 0">
<div class="row g-3">
@foreach([['Published', $notice->publish_date ? \Carbon\Carbon::parse($notice->publish_date)->format('d M Y') : '-'],['Expires', $notice->expiry_date ? \Carbon\Carbon::parse($notice->expiry_date)->format('d M Y') : '-'],['Created', $notice->created_at->format('d M Y h:i A')]] as [$label,$val])
<div class="col-md-4"><div style="font-size:.72rem;color:var(--text-muted)">{{ $label }}</div><div style="font-size:.875rem;font-weight:600">{{ $val }}</div></div>
@endforeach
</div>
</div></div></div></div>
@endsection
