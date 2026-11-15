@extends('layouts.dashboard')
@section('title','Form Submissions')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
    <div>
        <h1 class="page-title">Form Submissions</h1>
        <p style="color:var(--text-muted);font-size:.875rem;margin:0">All website forms collected in one place.</p>
    </div>
    <a href="{{ route('admin.form-submissions.export', request()->only('type')) }}" class="btn-primary-sc btn-sm-sc">
        <i class="bi bi-file-earmark-excel me-1"></i> Export to Excel
    </a>
</div>

@if(session('error'))
<div class="sc-alert danger mb-3"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>
@endif

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="sc-card stat-card">
            <div class="stat-icon blue"><i class="bi bi-inbox"></i></div>
            <div class="stat-info"><span class="stat-num">{{ number_format($total) }}</span><span class="stat-label">Total Submissions</span></div>
        </div>
    </div>
    @foreach($types as $type)
    <div class="col-sm-6 col-lg-3">
        <div class="sc-card stat-card">
            <div class="stat-icon cyan"><i class="bi bi-file-earmark-text"></i></div>
            <div class="stat-info"><span class="stat-num">{{ number_format($type->total) }}</span><span class="stat-label">{{ $type->form_type }}</span></div>
        </div>
    </div>
    @endforeach
</div>

<div class="dashboard-card mb-4">
    <div class="card-body-sc">
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <div class="sc-search-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" class="sc-input" placeholder="Search name, email or phone..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4">
                <select name="type" class="sc-select">
                    <option value="">All form types</option>
                    @foreach($types as $type)
                    <option value="{{ $type->form_type }}" {{ request('type') === $type->form_type ? 'selected' : '' }}>{{ $type->form_type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1"><button type="submit" class="btn-primary-sc btn-sm-sc w-100">Filter</button></div>
            <div class="col-md-2"><a href="{{ route('admin.form-submissions.index') }}" class="btn-outline-sc btn-sm-sc w-100">Clear</a></div>
        </form>
    </div>
</div>

<div class="dashboard-card animate-slide-up">
    <div class="sc-table-wrapper">
        <table class="sc-table">
            <thead><tr><th>Form</th><th>Submitted By</th><th>Contact</th><th>Details</th><th>Date</th></tr></thead>
            <tbody>
            @forelse($submissions as $submission)
                @php
                    $details = collect($submission->payload ?? [])->map(function ($value, $key) {
                        if (is_array($value)) $value = implode(', ', $value);
                        return ucfirst(str_replace('_', ' ', $key)) . ': ' . $value;
                    })->implode(' · ');
                @endphp
                <tr>
                    <td><span class="sc-badge badge-primary">{{ $submission->form_type }}</span></td>
                    <td><div style="font-weight:600;font-size:.85rem">{{ $submission->name ?: '—' }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $submission->user_id ? 'Registered user' : 'Guest' }}</div></td>
                    <td><div style="font-size:.82rem">{{ $submission->email ?: '—' }}</div><div style="font-size:.75rem;color:var(--text-muted)">{{ $submission->phone ?: '—' }}</div></td>
                    <td style="font-size:.78rem;max-width:360px;white-space:normal;color:var(--text-muted)">{{ \Illuminate\Support\Str::limit($details, 180) ?: '—' }}</td>
                    <td style="font-size:.78rem;color:var(--text-muted);white-space:nowrap">{{ $submission->created_at->format('d M Y, h:i A') }}</td>
                </tr>
            @empty
                <tr><td colspan="5"><div class="empty-state"><div class="empty-icon"><i class="bi bi-inbox"></i></div><h4>No form submissions found</h4><p>New website form entries will appear here.</p></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($submissions->hasPages())
    <div class="card-body-sc pt-0">{{ $submissions->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
