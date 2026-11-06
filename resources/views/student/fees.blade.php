@extends('layouts.dashboard')
@section('title','Fee Details')
@section('page_title','Fee Details')
@section('breadcrumb')<a href="{{ route('student.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Fee Details</span>@endsection
@section('sidebar')@include('student.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Fee Details</h1><p style="color:var(--text-muted);font-size:.875rem">Track your fee payments and dues</p></div>
</div>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-4 animate-slide-up anim-delay-1">
        <div class="sc-card stat-card">
            <div class="stat-icon green"><i class="bi bi-check-circle-fill"></i></div>
            <div class="stat-info">
                <span class="stat-num" style="font-size:1.3rem">₹{{ number_format($stats['total_paid']) }}</span>
                <span class="stat-label">Total Paid</span>
            </div>
        </div>
    </div>
    <div class="col-md-4 animate-slide-up anim-delay-2">
        <div class="sc-card stat-card">
            <div class="stat-icon {{ $stats['fees_due'] > 0 ? 'red' : 'green' }}"><i class="bi bi-{{ $stats['fees_due'] > 0 ? 'exclamation-triangle' : 'check-circle' }}-fill"></i></div>
            <div class="stat-info">
                <span class="stat-num" style="font-size:1.3rem">{{ $stats['fees_due'] > 0 ? '₹'.number_format($stats['fees_due']) : 'Nil' }}</span>
                <span class="stat-label">Fees Due</span>
            </div>
        </div>
    </div>
    <div class="col-md-4 animate-slide-up anim-delay-3">
        <div class="sc-card stat-card">
            <div class="stat-icon blue"><i class="bi bi-receipt"></i></div>
            <div class="stat-info">
                <span class="stat-num" data-counter="{{ $payments->total() }}">0</span>
                <span class="stat-label">Total Payments</span>
            </div>
        </div>
    </div>
</div>

@if($stats['fees_due'] > 0)
<div class="sc-alert danger mb-4 animate-fade-down">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <div>You have <strong>₹{{ number_format($stats['fees_due']) }}</strong> in pending fees. Please contact the accounts office or pay online.</div>
</div>
@else
<div class="sc-alert success mb-4 animate-fade-down">
    <i class="bi bi-check-circle-fill"></i>
    <div>All fees are cleared! You have no pending dues.</div>
</div>
@endif

<!-- Fee Structure -->
@if($fees->count())
<div class="dashboard-card mb-4 animate-slide-up anim-delay-1">
    <div class="card-header-sc"><h5><i class="bi bi-list-check me-2 text-primary-sc"></i>Fee Structure</h5></div>
    <div class="sc-table-wrapper">
        <table class="sc-table">
            <thead><tr><th>Fee Type</th><th>Amount</th><th>Academic Year</th><th>Semester</th><th>Due Date</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($fees as $fee)
            <tr>
                <td style="font-weight:600;font-size:.875rem">{{ ucfirst(str_replace('_',' ',$fee->fee_type)) }}</td>
                <td style="font-weight:700;color:var(--primary);font-size:.9rem">₹{{ number_format($fee->amount) }}</td>
                <td style="font-size:.82rem">{{ $fee->academic_year }}</td>
                <td><span class="sc-badge badge-info">Sem {{ $fee->semester }}</span></td>
                <td style="font-size:.82rem;color:{{ now()->gt($fee->due_date)?'var(--danger)':'var(--text-muted)' }}">{{ $fee->due_date ? \Carbon\Carbon::parse($fee->due_date)->format('d M Y') : '-' }}</td>
                <td><span class="sc-badge {{ $fee->status=='active'?'badge-success':'badge-secondary' }}">{{ ucfirst($fee->status) }}</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Payment History -->
<div class="dashboard-card animate-slide-up anim-delay-2">
    <div class="card-header-sc"><h5><i class="bi bi-clock-history me-2 text-primary-sc"></i>Payment History</h5></div>
    <div class="sc-table-wrapper">
        <table class="sc-table">
            <thead><tr><th>Receipt No.</th><th>Amount</th><th>Method</th><th>Date</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($payments as $i => $p)
            <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
                <td><code style="font-size:.78rem;color:var(--primary);background:var(--primary-light);padding:2px 7px;border-radius:4px">{{ $p->receipt_number }}</code></td>
                <td style="font-weight:800;color:var(--success);font-size:.95rem">₹{{ number_format($p->amount_paid) }}</td>
                <td><span class="sc-badge badge-info">{{ ucfirst($p->payment_method ?? 'N/A') }}</span></td>
                <td style="font-size:.82rem">{{ \Carbon\Carbon::parse($p->payment_date)->format('d M Y') }}</td>
                <td><span class="sc-badge badge-success"><i class="bi bi-check-circle me-1"></i>{{ ucfirst($p->status) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5">
                <div class="empty-state py-4">
                    <div class="empty-icon"><i class="bi bi-receipt"></i></div>
                    <h4>No payment records</h4>
                    <p>No fee payments found</p>
                </div>
            </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())
    <div class="card-body-sc pt-0">{{ $payments->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
