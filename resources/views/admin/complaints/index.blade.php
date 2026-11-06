@extends('layouts.dashboard')
@section('title','Complaints')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Complaints</h1></div></div>
<div class="dashboard-card mb-4 animate-slide-up"><div class="card-body-sc"><form method="GET" class="row g-2">
<div class="col-md-4"><div class="sc-search-wrapper"><i class="bi bi-search"></i><input type="text" name="search" class="sc-input" placeholder="Search..." value="{{ request('search') }}"></div></div>
<div class="col-md-2"><select name="status" class="sc-select"><option value="">All Status</option><option value="open">Open</option><option value="in_progress">In Progress</option><option value="resolved">Resolved</option></select></div>
<div class="col-md-2"><select name="priority" class="sc-select"><option value="">All Priority</option><option value="high">High</option><option value="medium">Medium</option><option value="low">Low</option></select></div>
<div class="col-md-2"><button type="submit" class="btn-primary-sc btn-sm-sc w-100">Filter</button></div>
<div class="col-md-2"><a href="{{ route('admin.complaints.index') }}" class="btn-outline-sc btn-sm-sc w-100">Clear</a></div>
</form></div></div>
<div class="dashboard-card animate-slide-up anim-delay-2">
<div class="sc-table-wrapper"><table class="sc-table"><thead><tr><th>Subject</th><th>By</th><th>Category</th><th>Priority</th><th>Status</th><th>Date</th><th>Action</th></tr></thead><tbody>
@forelse($complaints as $i => $c)
<tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
<td style="font-weight:600;font-size:.875rem">{{ Str::limit($c->subject,35) }}</td>
<td style="font-size:.82rem">{{ $c->user->name ?? '-' }}</td>
<td><span class="sc-badge badge-info">{{ ucfirst($c->category) }}</span></td>
<td><span class="sc-badge {{ $c->priority=='high'?'badge-danger':($c->priority=='medium'?'badge-warning':'badge-secondary') }}">{{ ucfirst($c->priority) }}</span></td>
<td><span class="sc-badge {{ $c->status=='open'?'badge-danger':($c->status=='resolved'?'badge-success':'badge-warning') }}">{{ ucfirst(str_replace('_',' ',$c->status)) }}</span></td>
<td style="font-size:.78rem;color:var(--text-muted)">{{ $c->created_at->format('d M Y') }}</td>
<td><a href="{{ route('admin.complaints.show',$c) }}" class="table-action-btn view"><i class="bi bi-eye"></i></a></td>
</tr>
@empty<tr><td colspan="7"><div class="empty-state"><div class="empty-icon"><i class="bi bi-chat-left-text"></i></div><h4>No complaints</h4></div></td></tr>@endforelse
</tbody></table></div>
@if($complaints->hasPages())<div class="card-body-sc pt-0">{{ $complaints->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
