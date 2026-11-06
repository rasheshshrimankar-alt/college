@extends('layouts.dashboard')
@section('title','Complaint')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Complaint Details</h1></div><a href="{{ route('admin.complaints.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
<div class="row g-4">
<div class="col-lg-8 animate-slide-up anim-delay-1">
<div class="dashboard-card">
<div class="card-body-sc">
<div class="d-flex gap-2 mb-3">
<span class="sc-badge {{ $complaint->priority=='high'?'badge-danger':($complaint->priority=='medium'?'badge-warning':'badge-secondary') }}">{{ ucfirst($complaint->priority) }} Priority</span>
<span class="sc-badge {{ $complaint->status=='open'?'badge-danger':($complaint->status=='resolved'?'badge-success':'badge-warning') }}">{{ ucfirst(str_replace('_',' ',$complaint->status)) }}</span>
<span class="sc-badge badge-info">{{ ucfirst($complaint->category) }}</span>
</div>
<h4 style="font-weight:800;margin-bottom:1rem">{{ $complaint->subject }}</h4>
<div style="background:var(--bg);border-radius:10px;padding:1rem;font-size:.875rem;color:var(--text-muted);line-height:1.7;margin-bottom:1.5rem">{{ $complaint->description }}</div>
@if($complaint->admin_response)
<div style="background:rgba(49,87,213,.06);border:1px solid rgba(49,87,213,.15);border-radius:10px;padding:1rem">
<div style="font-size:.72rem;font-weight:700;color:var(--primary);margin-bottom:.5rem;text-transform:uppercase">Admin Response</div>
<p style="font-size:.875rem;color:var(--text);margin:0">{{ $complaint->admin_response }}</p>
</div>
@else
<form method="POST" action="{{ route('admin.complaints.respond',$complaint) }}" data-validate>@csrf
<div class="sc-form-group"><label class="sc-label">Add Response</label><textarea name="response" class="sc-input" rows="4" required placeholder="Enter your response..."></textarea></div>
<div class="d-flex gap-2">
<button type="submit" class="btn-primary-sc"><i class="bi bi-send me-2"></i>Send Response</button>
<select name="status" class="sc-select" style="width:auto" form="this.closest('form')"><option value="in_progress">Mark In Progress</option><option value="resolved">Mark Resolved</option></select>
</div>
</form>
@endif
</div>
</div>
</div>
<div class="col-lg-4 animate-slide-up anim-delay-2">
<div class="dashboard-card">
<div class="card-header-sc"><h5><i class="bi bi-person me-2 text-primary-sc"></i>Submitted By</h5></div>
<div class="card-body-sc text-center">
<img src="{{ $complaint->user->avatar_url }}" style="width:70px;height:70px;border-radius:50%;border:3px solid var(--primary-light);margin-bottom:.75rem">
<h6 style="font-weight:700">{{ $complaint->user->name ?? 'Unknown' }}</h6>
<div style="font-size:.78rem;color:var(--text-muted)">{{ $complaint->user->email ?? '' }}</div>
<div style="font-size:.78rem;color:var(--text-muted);margin-top:.5rem"><i class="bi bi-clock me-1"></i>{{ $complaint->created_at->diffForHumans() }}</div>
</div>
</div>
</div>
</div>
@endsection
