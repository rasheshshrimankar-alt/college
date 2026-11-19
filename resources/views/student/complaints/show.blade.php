@extends('layouts.dashboard')
@section('title','Complaint Details')
@section('page_title','Complaint Details')
@section('breadcrumb')<a href="{{ route('student.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><a href="{{ route('student.complaints.index') }}">Complaints</a><i class="bi bi-chevron-right"></i><span>Details</span>@endsection
@section('sidebar')@include('student.partials.sidebar')@endsection
@section('content')
<div class="page-header"><div><h1 class="page-title">Complaint Details</h1></div><a href="{{ route('student.complaints.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left me-1"></i>Back</a></div>
<div class="dashboard-card"><div class="card-body-sc">
<div class="d-flex flex-wrap gap-2 mb-3"><span class="sc-badge badge-info">{{ ucfirst($complaint->category) }}</span><span class="sc-badge {{ $complaint->priority==='high'?'badge-danger':($complaint->priority==='medium'?'badge-warning':'badge-secondary') }}">{{ ucfirst($complaint->priority) }} priority</span><span class="sc-badge {{ $complaint->status==='resolved'?'badge-success':($complaint->status==='open'?'badge-danger':'badge-warning') }}">{{ ucfirst(str_replace('_',' ',$complaint->status)) }}</span></div>
<h3 class="h5 fw-bold">{{ $complaint->subject }}</h3><p class="text-muted small">Submitted {{ $complaint->created_at->format('d M Y, h:i A') }}</p><div class="p-3 rounded-3" style="background:var(--bg);white-space:pre-wrap">{{ $complaint->description }}</div>
<div class="mt-4"><h5 class="fw-bold">College response</h5>@if($complaint->admin_response)<div class="alert alert-info mb-0">{{ $complaint->admin_response }}</div>@else<p class="text-muted mb-0">No response yet. Please check again later.</p>@endif</div>
</div></div>
@endsection
