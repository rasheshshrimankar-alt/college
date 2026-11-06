@extends('layouts.dashboard')
@section('title','Admissions')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Admissions</h1></div></div>
<div class="row g-3 mb-4">
<div class="col-6 col-md-3 animate-slide-up anim-delay-1"><div class="sc-card stat-card"><div class="stat-icon blue"><i class="bi bi-people"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['total'] }}">0</span><span class="stat-label">Total</span></div></div></div>
<div class="col-6 col-md-3 animate-slide-up anim-delay-2"><div class="sc-card stat-card"><div class="stat-icon orange"><i class="bi bi-clock"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['pending'] }}">0</span><span class="stat-label">Pending</span></div></div></div>
<div class="col-6 col-md-3 animate-slide-up anim-delay-3"><div class="sc-card stat-card"><div class="stat-icon green"><i class="bi bi-check-circle"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['approved'] }}">0</span><span class="stat-label">Approved</span></div></div></div>
<div class="col-6 col-md-3 animate-slide-up anim-delay-4"><div class="sc-card stat-card"><div class="stat-icon red"><i class="bi bi-x-circle"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['rejected'] }}">0</span><span class="stat-label">Rejected</span></div></div></div>
</div>
<div class="dashboard-card mb-4 animate-slide-up"><div class="card-body-sc"><form method="GET" class="row g-2">
<div class="col-md-4"><div class="sc-search-wrapper"><i class="bi bi-search"></i><input type="text" name="search" class="sc-input" placeholder="Search applicant..." value="{{ request('search') }}"></div></div>
<div class="col-md-3"><select name="status" class="sc-select"><option value="">All Status</option><option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option><option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option><option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option><option value="waitlisted" {{ request('status')=='waitlisted'?'selected':'' }}>Waitlisted</option></select></div>
<div class="col-md-2"><button type="submit" class="btn-primary-sc btn-sm-sc w-100">Filter</button></div>
<div class="col-md-2"><a href="{{ route('admin.admissions.index') }}" class="btn-outline-sc btn-sm-sc w-100">Clear</a></div>
</form></div></div>
<div class="dashboard-card animate-slide-up anim-delay-2">
<div class="sc-table-wrapper"><table class="sc-table"><thead><tr><th>App No.</th><th>Applicant</th><th>Course</th><th>%</th><th>Status</th><th>Applied</th><th>Action</th></tr></thead><tbody>
@forelse($admissions as $i => $adm)
<tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
<td><code style="font-size:.72rem;background:var(--primary-light);color:var(--primary);padding:2px 6px;border-radius:4px">{{ $adm->application_number }}</code></td>
<td><div style="font-weight:600;font-size:.85rem">{{ $adm->applicant_name }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $adm->applicant_email }}</div></td>
<td style="font-size:.82rem">{{ Str::limit($adm->course->name ?? '-',22) }}</td>
<td style="font-weight:600;color:{{ $adm->previous_percentage>=75?'var(--success)':'var(--warning)' }}">{{ number_format($adm->previous_percentage,1) }}%</td>
<td><span class="sc-badge {{ $adm->status=='approved'?'badge-success':($adm->status=='rejected'?'badge-danger':($adm->status=='waitlisted'?'badge-info':'badge-warning')) }}">{{ ucfirst($adm->status) }}</span></td>
<td style="font-size:.78rem;color:var(--text-muted)">{{ $adm->created_at->format('d M Y') }}</td>
<td><a href="{{ route('admin.admissions.show',$adm) }}" class="table-action-btn view"><i class="bi bi-eye"></i></a></td>
</tr>
@empty<tr><td colspan="7"><div class="empty-state"><div class="empty-icon"><i class="bi bi-inbox"></i></div><h4>No applications yet</h4></div></td></tr>@endforelse
</tbody></table></div>
@if($admissions->hasPages())<div class="card-body-sc pt-0">{{ $admissions->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
