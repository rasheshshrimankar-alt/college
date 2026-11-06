@extends('layouts.dashboard')
@section('title','Library')
@section('page_title','Library')
@section('breadcrumb')<a href="{{ route('student.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Library</span>@endsection
@section('sidebar')@include('student.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Library</h1><p style="color:var(--text-muted);font-size:.875rem">Browse and borrow books</p></div>
</div>

<!-- My Issued Books -->
@if($myIssues->count())
<div class="dashboard-card mb-4 animate-slide-up anim-delay-1">
    <div class="card-header-sc"><h5><i class="bi bi-bookmark-check me-2 text-primary-sc"></i>My Issued Books</h5><span class="sc-badge badge-primary">{{ $myIssues->count() }} Issued</span></div>
    <div class="sc-table-wrapper">
        <table class="sc-table">
            <thead><tr><th>Book</th><th>Author</th><th>Issue Date</th><th>Due Date</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($myIssues as $issue)
            <tr>
                <td><div style="font-weight:600;font-size:.875rem">{{ $issue->book->title ?? 'N/A' }}</div><div style="font-size:.72rem;color:var(--text-muted)">ISBN: {{ $issue->book->isbn ?? '-' }}</div></td>
                <td style="font-size:.82rem">{{ $issue->book->author ?? '-' }}</td>
                <td style="font-size:.82rem">{{ \Carbon\Carbon::parse($issue->issue_date)->format('d M Y') }}</td>
                <td style="font-size:.82rem;color:{{ $issue->due_date && now()->gt($issue->due_date)?'var(--danger)':'var(--text)' }}">{{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('d M Y') : '-' }}</td>
                <td><span class="sc-badge {{ $issue->status=='returned'?'badge-success':($issue->due_date && now()->gt($issue->due_date)?'badge-danger':'badge-warning') }}">{{ ucfirst($issue->status ?? 'issued') }}</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Available Books -->
<div class="dashboard-card animate-slide-up anim-delay-2">
    <div class="card-header-sc"><h5><i class="bi bi-journals me-2 text-primary-sc"></i>Available Books</h5><span class="sc-badge badge-success">{{ $books->total() }} Books</span></div>
    <div class="sc-table-wrapper">
        <table class="sc-table">
            <thead><tr><th>Title</th><th>Author</th><th>Category</th><th>Available</th><th>Location</th></tr></thead>
            <tbody>
            @forelse($books as $i => $book)
            <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
                <td>
                    <div style="font-weight:600;font-size:.875rem">{{ $book->title }}</div>
                    <div style="font-size:.72rem;color:var(--text-muted)">ISBN: {{ $book->isbn }}</div>
                </td>
                <td style="font-size:.82rem">{{ $book->author }}</td>
                <td><span class="sc-badge badge-info" style="font-size:.65rem">{{ $book->category }}</span></td>
                <td style="font-weight:700;color:{{ $book->available_copies > 0 ? 'var(--success)' : 'var(--danger)' }}">{{ $book->available_copies }}/{{ $book->total_copies }}</td>
                <td style="font-size:.78rem;color:var(--text-muted)"><i class="bi bi-geo-alt me-1"></i>{{ $book->location ?? 'Library' }}</td>
            </tr>
            @empty
            <tr><td colspan="5"><div class="empty-state py-4"><div class="empty-icon"><i class="bi bi-journals"></i></div><h4>No books available</h4></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($books->hasPages())
    <div class="card-body-sc pt-0">{{ $books->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
