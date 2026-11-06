@extends('layouts.dashboard')
@section('title','My Complaints')
@section('page_title','My Complaints')
@section('breadcrumb')<a href="{{ route('student.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Complaints</span>@endsection
@section('sidebar')@include('student.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">My Complaints</h1></div>
    <a href="{{ route('student.complaints.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg me-1"></i>New Complaint</a>
</div>
<div class="dashboard-card animate-slide-up">
    <div class="sc-table-wrapper"><table class="sc-table">
        <thead><tr><th>#</th><th>Subject</th><th>Category</th><th>Priority</th><th>Status</th><th>Date</th><th>View</th></tr></thead>
        <tbody>
        @forelse($complaints as $i => $c)
        <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
            <td style="color:var(--text-muted);font-size:.78rem">{{ $complaints->firstItem()+$i }}</td>
            <td style="font-weight:600;font-size:.875rem">{{ Str::limit($c->subject, 45) }}</td>
            <td><span class="sc-badge badge-info">{{ ucfirst($c->category) }}</span></td>
            <td><span class="sc-badge {{ $c->priority=='high'?'badge-danger':($c->priority=='medium'?'badge-warning':'badge-secondary') }}">{{ ucfirst($c->priority) }}</span></td>
            <td><span class="sc-badge {{ $c->status=='open'?'badge-danger':($c->status=='resolved'?'badge-success':'badge-warning') }}">{{ ucfirst(str_replace('_',' ',$c->status)) }}</span></td>
            <td style="font-size:.78rem;color:var(--text-muted)">{{ $c->created_at->format('d M Y') }}</td>
            <td><a href="{{ route('student.complaints.show', $c) }}" class="table-action-btn view"><i class="bi bi-eye"></i></a></td>
        </tr>
        @empty
        <tr><td colspan="7"><div class="empty-state py-4">
            <div class="empty-icon"><i class="bi bi-chat-left-text"></i></div>
            <h4>No complaints yet</h4>
            <p>Have an issue? Raise a complaint and we'll resolve it.</p>
            <a href="{{ route('student.complaints.create') }}" class="btn-primary-sc mt-3">Raise Complaint</a>
        </div></td></tr>
        @endforelse
        </tbody>
    </table></div>
    @if($complaints->hasPages())<div class="card-body-sc pt-0">{{ $complaints->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
