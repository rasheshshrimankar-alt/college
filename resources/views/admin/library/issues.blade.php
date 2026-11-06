@extends('layouts.dashboard')
@section('title','Book Issues')
@section('page_title','Book Issues')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><a href="{{ route('admin.library.index') }}">Library</a><i class="bi bi-chevron-right"></i><span>Issues</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Book Issues</h1><p style="color:var(--text-muted);font-size:.875rem">{{ $issues->total() }} total book issues</p></div>
</div>
<div class="dashboard-card mb-4 animate-slide-up">
    <div class="card-header-sc"><h5><i class="bi bi-bookmark-plus me-2 text-primary-sc"></i>Issue New Book</h5></div>
    <div class="card-body-sc">
        <form method="POST" action="{{ route('admin.library.issue-book') }}" class="row g-3">
            @csrf
            <div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Book</label><select name="library_book_id" class="sc-select" required>@foreach(App\Models\LibraryBook::where('available_copies','>',0)->get() as $b)<option value="{{ $b->id }}">{{ $b->title }} ({{ $b->available_copies }} available)</option>@endforeach</select></div></div>
            <div class="col-md-4"><div class="sc-form-group"><label class="sc-label">Student</label><select name="student_id" class="sc-select" required>@foreach(App\Models\Student::with('user')->get() as $s)<option value="{{ $s->id }}">{{ $s->user->name ?? '' }} ({{ $s->student_id }})</option>@endforeach</select></div></div>
            <div class="col-md-3"><div class="sc-form-group"><label class="sc-label">Due Date</label><input type="date" name="due_date" class="sc-input" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required></div></div>
            <div class="col-md-1 d-flex align-items-end"><button type="submit" class="btn-primary-sc btn-sm-sc w-100"><i class="bi bi-check-lg"></i></button></div>
        </form>
    </div>
</div>
<div class="dashboard-card animate-slide-up anim-delay-2">
    <div class="sc-table-wrapper"><table class="sc-table">
        <thead><tr><th>#</th><th>Book</th><th>Student</th><th>Issue Date</th><th>Due Date</th><th>Return Date</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($issues as $i => $issue)
        <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
            <td style="color:var(--text-muted);font-size:.78rem">{{ $issues->firstItem()+$i }}</td>
            <td><div style="font-weight:600;font-size:.875rem">{{ $issue->book->title ?? '-' }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $issue->book->author ?? '' }}</div></td>
            <td><div style="font-weight:600;font-size:.875rem">{{ $issue->student->user->name ?? '-' }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $issue->student->student_id ?? '' }}</div></td>
            <td style="font-size:.82rem">{{ \Carbon\Carbon::parse($issue->issue_date)->format('d M Y') }}</td>
            <td style="font-size:.82rem;color:{{ $issue->status!='returned' && $issue->due_date && now()->gt($issue->due_date)?'var(--danger)':'var(--text-muted)' }}">{{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('d M Y') : '-' }}</td>
            <td style="font-size:.82rem;color:var(--success)">{{ $issue->return_date ? \Carbon\Carbon::parse($issue->return_date)->format('d M Y') : '—' }}</td>
            <td><span class="sc-badge {{ $issue->status=='returned'?'badge-success':($issue->due_date && now()->gt($issue->due_date)?'badge-danger':'badge-warning') }}">{{ ucfirst($issue->status ?? 'issued') }}</span></td>
            <td>@if($issue->status!='returned')<form method="POST" action="{{ route('admin.library.return',$issue) }}" style="display:inline">@csrf @method('PATCH')<button type="submit" class="btn-primary-sc btn-sm-sc" style="font-size:.72rem" onclick="return confirm('Mark as returned?')"><i class="bi bi-check me-1"></i>Return</button></form>@endif</td>
        </tr>
        @empty<tr><td colspan="8"><div class="empty-state"><div class="empty-icon"><i class="bi bi-bookmark-x"></i></div><h4>No book issues</h4></div></td></tr>@endforelse
        </tbody>
    </table></div>
    @if($issues->hasPages())<div class="card-body-sc pt-0">{{ $issues->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
