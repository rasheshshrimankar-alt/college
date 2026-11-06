@extends('layouts.dashboard')
@section('title','Complaints')
@section('page_title','Complaints')
@section('breadcrumb')<a href="{{ route('faculty.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Complaints</span>@endsection
@section('sidebar')@include('faculty.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Student Complaints</h1></div></div>
<div class="dashboard-card animate-slide-up">
    <div class="sc-table-wrapper"><table class="sc-table">
        <thead><tr><th>#</th><th>Subject</th><th>Submitted By</th><th>Category</th><th>Priority</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
        @forelse($complaints as $i => $c)
        <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
            <td style="color:var(--text-muted);font-size:.78rem">{{ $complaints->firstItem()+$i }}</td>
            <td style="font-weight:600;font-size:.875rem">{{ Str::limit($c->subject, 40) }}</td>
            <td style="font-size:.82rem">{{ $c->user->name ?? '-' }}</td>
            <td><span class="sc-badge badge-info">{{ ucfirst($c->category ?? 'general') }}</span></td>
            <td><span class="sc-badge {{ $c->priority=='high'?'badge-danger':($c->priority=='medium'?'badge-warning':'badge-secondary') }}">{{ ucfirst($c->priority ?? 'low') }}</span></td>
            <td><span class="sc-badge {{ $c->status=='open'?'badge-danger':($c->status=='resolved'?'badge-success':'badge-warning') }}">{{ ucfirst(str_replace('_',' ',$c->status)) }}</span></td>
            <td style="font-size:.78rem;color:var(--text-muted)">{{ $c->created_at->format('d M Y') }}</td>
        </tr>
        @empty
        <tr><td colspan="7"><div class="empty-state py-4"><div class="empty-icon"><i class="bi bi-chat-left-text"></i></div><h4>No complaints</h4></div></td></tr>
        @endforelse
        </tbody>
    </table></div>
    @if($complaints->hasPages())<div class="card-body-sc pt-0">{{ $complaints->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
