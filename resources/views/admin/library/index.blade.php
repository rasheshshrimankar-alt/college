@extends('layouts.dashboard')
@section('title','Library')
@section('page_title','Library')
@section('breadcrumb')<a href="{{ route('admin.dashboard') }}">Home</a><i class="bi bi-chevron-right"></i><span>Library</span>@endsection
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Library Management</h1><p style="color:var(--text-muted);font-size:.875rem">{{ $books->total() }} books catalogued</p></div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.library.issues') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-bookmark-check"></i> Issues</a>
        <a href="{{ route('admin.library.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg"></i> Add Book</a>
    </div>
</div>
<div class="dashboard-card mb-4 animate-slide-up">
    <div class="card-body-sc">
        <form method="GET" class="row g-2"><div class="col-md-4"><div class="sc-search-wrapper"><i class="bi bi-search"></i><input type="text" name="search" class="sc-input" placeholder="Search title or author..." value="{{ request('search') }}"></div></div><div class="col-md-3"><select name="category" class="sc-select"><option value="">All Categories</option>@foreach($categories as $cat)<option value="{{ $cat }}" {{ request('category')==$cat?'selected':'' }}>{{ $cat }}</option>@endforeach</select></div><div class="col-md-2 d-flex gap-2"><button type="submit" class="btn-primary-sc btn-sm-sc flex-fill"><i class="bi bi-search"></i></button><a href="{{ route('admin.library.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-x-lg"></i></a></div></form>
    </div>
</div>
<div class="dashboard-card animate-slide-up anim-delay-2">
    <div class="sc-table-wrapper"><table class="sc-table">
        <thead><tr><th>#</th><th>Title</th><th>Author</th><th>ISBN</th><th>Category</th><th>Copies</th><th>Available</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($books as $i => $book)
        <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
            <td style="color:var(--text-muted);font-size:.78rem">{{ $books->firstItem()+$i }}</td>
            <td><div style="font-weight:600;font-size:.875rem">{{ $book->title }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $book->publisher ?? '' }} {{ $book->publication_year ? '('.$book->publication_year.')' : '' }}</div></td>
            <td style="font-size:.82rem">{{ $book->author }}</td>
            <td><code style="font-size:.72rem;color:var(--primary)">{{ $book->isbn ?? '-' }}</code></td>
            <td><span class="sc-badge badge-info">{{ $book->category }}</span></td>
            <td style="font-weight:700;text-align:center">{{ $book->total_copies }}</td>
            <td><span style="font-weight:700;color:{{ $book->available_copies>0?'var(--success)':'var(--danger)' }}">{{ $book->available_copies }}</span></td>
            <td><span class="sc-badge {{ $book->available_copies>0?'badge-success':'badge-danger' }}">{{ $book->available_copies>0?'Available':'Out of Stock' }}</span></td>
            <td><div class="d-flex gap-1">
                <a href="{{ route('admin.library.edit',$book) }}" class="table-action-btn edit"><i class="bi bi-pencil"></i></a>
                <form method="POST" action="{{ route('admin.library.destroy',$book) }}" style="display:inline">@csrf @method('DELETE')<button class="table-action-btn delete" data-confirm="Delete this book?"><i class="bi bi-trash"></i></button></form>
            </div></td>
        </tr>
        @empty<tr><td colspan="9"><div class="empty-state"><div class="empty-icon"><i class="bi bi-journals"></i></div><h4>No books</h4><a href="{{ route('admin.library.create') }}" class="btn-primary-sc mt-3">Add Book</a></div></td></tr>@endforelse
        </tbody>
    </table></div>
    @if($books->hasPages())<div class="card-body-sc pt-0">{{ $books->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
