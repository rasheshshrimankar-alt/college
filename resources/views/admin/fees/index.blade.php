@extends('layouts.dashboard')
@section('title','Fee Management')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Fee Management</h1></div></div>
<div class="row g-3 mb-4">
<div class="col-6 col-lg-3 animate-slide-up anim-delay-1"><div class="sc-card stat-card"><div class="stat-icon green"><i class="bi bi-cash-stack"></i></div><div class="stat-info"><span class="stat-num" style="font-size:1.1rem">₹{{ number_format($stats['total_collected']/1000,1) }}K</span><span class="stat-label">Total Collected</span></div></div></div>
<div class="col-6 col-lg-3 animate-slide-up anim-delay-2"><div class="sc-card stat-card"><div class="stat-icon red"><i class="bi bi-clock"></i></div><div class="stat-info"><span class="stat-num" style="font-size:1.1rem">₹{{ number_format($stats['total_pending']/1000,1) }}K</span><span class="stat-label">Total Pending</span></div></div></div>
<div class="col-6 col-lg-3 animate-slide-up anim-delay-3"><div class="sc-card stat-card"><div class="stat-icon blue"><i class="bi bi-people"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['paid_students'] }}">0</span><span class="stat-label">Paid Students</span></div></div></div>
<div class="col-6 col-lg-3 animate-slide-up anim-delay-4"><div class="sc-card stat-card"><div class="stat-icon orange"><i class="bi bi-exclamation-circle"></i></div><div class="stat-info"><span class="stat-num" data-counter="{{ $stats['defaulters'] }}">0</span><span class="stat-label">Defaulters</span></div></div></div>
</div>
<div class="dashboard-card animate-slide-up anim-delay-2">
<div class="card-header-sc"><h5><i class="bi bi-cash me-2 text-primary-sc"></i>Recent Payments</h5><a href="{{ route('admin.fees.report') }}" class="sc-badge badge-primary">Full Report</a></div>
<div class="sc-table-wrapper"><table class="sc-table"><thead><tr><th>Receipt</th><th>Student</th><th>Amount</th><th>Method</th><th>Semester</th><th>Date</th><th>Status</th></tr></thead><tbody>
@forelse($payments as $i => $p)
<tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
<td><code style="font-size:.72rem;color:var(--primary)">{{ $p->receipt_number }}</code></td>
<td><div style="font-weight:600;font-size:.85rem">{{ $p->student->user->name ?? '-' }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $p->student->student_id ?? '' }}</div></td>
<td style="font-weight:700;color:var(--success)">₹{{ number_format($p->amount_paid) }}</td>
<td><span class="sc-badge badge-info">{{ ucfirst($p->payment_method) }}</span></td>
<td><span class="sc-badge badge-secondary">Sem {{ $p->semester }}</span></td>
<td style="font-size:.78rem;color:var(--text-muted)">{{ \Carbon\Carbon::parse($p->payment_date)->format('d M Y') }}</td>
<td><span class="sc-badge badge-success">{{ ucfirst($p->status) }}</span></td>
</tr>
@empty<tr><td colspan="7"><div class="empty-state"><div class="empty-icon"><i class="bi bi-cash"></i></div><h4>No payments</h4></div></td></tr>@endforelse
</tbody></table></div>
@if($payments->hasPages())<div class="card-body-sc pt-0">{{ $payments->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
