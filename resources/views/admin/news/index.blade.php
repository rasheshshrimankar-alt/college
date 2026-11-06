@extends('layouts.dashboard')
@section('title','News')
@section('page_title','News')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><span>News</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">News Management</h1><p style="color:var(--text-muted);font-size:.875rem">{{ $news->total() }} articles</p></div>
    <a href="{{ route('admin.news.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg"></i> Add News</a>
</div>
<div class="dashboard-card mb-4 animate-slide-up">
    <div class="card-body-sc">
        <form method="GET" class="row g-2"><div class="col-md-6"><div class="sc-search-wrapper"><i class="bi bi-search"></i><input type="text" name="search" class="sc-input" placeholder="Search news..." value="{{ request('search') }}"></div></div><div class="col-md-2 d-flex gap-2"><button type="submit" class="btn-primary-sc btn-sm-sc flex-fill"><i class="bi bi-search"></i></button><a href="{{ route('admin.news.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-x-lg"></i></a></div></form>
    </div>
</div>
<div class="dashboard-card animate-slide-up anim-delay-2">
    <div class="sc-table-wrapper"><table class="sc-table">
        <thead><tr><th>#</th><th>Title</th><th>Category</th><th>Featured</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($news as $i => $n)
        <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
            <td style="color:var(--text-muted);font-size:.78rem">{{ $news->firstItem()+$i }}</td>
            <td><div style="font-weight:600;font-size:.875rem">{{ Str::limit($n->title,50) }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ Str::limit(strip_tags($n->content),60) }}</div></td>
            <td><span class="sc-badge badge-info">{{ ucfirst($n->category) }}</span></td>
            <td>@if($n->is_featured)<span class="sc-badge badge-warning"><i class="bi bi-star me-1"></i>Featured</span>@else<span style="font-size:.78rem;color:var(--text-muted)">—</span>@endif</td>
            <td><span class="sc-badge {{ $n->status=='published'?'badge-success':'badge-secondary' }}">{{ ucfirst($n->status) }}</span></td>
            <td style="font-size:.78rem;color:var(--text-muted)">{{ $n->created_at->format('d M Y') }}</td>
            <td><div class="d-flex gap-1">
                <a href="{{ route('admin.news.edit',$n) }}" class="table-action-btn edit"><i class="bi bi-pencil"></i></a>
                <form method="POST" action="{{ route('admin.news.destroy',$n) }}" style="display:inline">@csrf @method('DELETE')<button class="table-action-btn delete" data-confirm="Delete this news?"><i class="bi bi-trash"></i></button></form>
            </div></td>
        </tr>
        @empty
        <tr><td colspan="7"><div class="empty-state"><div class="empty-icon"><i class="bi bi-newspaper"></i></div><h4>No news articles</h4><a href="{{ route('admin.news.create') }}" class="btn-primary-sc mt-3">Add News</a></div></td></tr>
        @endforelse
        </tbody>
    </table></div>
    @if($news->hasPages())<div class="card-body-sc pt-0">{{ $news->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
