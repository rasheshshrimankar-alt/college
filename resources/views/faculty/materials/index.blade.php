@extends('layouts.dashboard')
@section('title','Study Materials')
@section('page_title','Study Materials')
@section('breadcrumb')<a href="{{ route('faculty.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Study Materials</span>@endsection
@section('sidebar')@include('faculty.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Study Materials</h1><p style="color:var(--text-muted);font-size:.875rem">Share resources with students</p></div>
    <a href="{{ route('faculty.materials.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg"></i> Upload Material</a>
</div>

<div class="dashboard-card animate-slide-up">
    <div class="sc-table-wrapper">
        <table class="sc-table">
            <thead><tr><th>#</th><th>Title</th><th>Subject</th><th>Type</th><th>Downloads</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($materials as $i => $m)
            <tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
                <td style="color:var(--text-muted);font-size:.78rem">{{ $materials->firstItem()+$i }}</td>
                <td>
                    <div style="font-weight:600;font-size:.875rem">{{ $m->title }}</div>
                    @if($m->description)<div style="font-size:.72rem;color:var(--text-muted)">{{ Str::limit($m->description,50) }}</div>@endif
                </td>
                <td style="font-size:.82rem">{{ $m->subject->name ?? '-' }}</td>
                <td>
                    @php $typeColors = ['pdf'=>'badge-danger','video'=>'badge-primary','ppt'=>'badge-warning','doc'=>'badge-info','link'=>'badge-secondary']; @endphp
                    <span class="sc-badge {{ $typeColors[$m->type ?? 'doc'] ?? 'badge-secondary' }}">{{ strtoupper($m->type ?? 'File') }}</span>
                </td>
                <td><span class="sc-badge badge-info">{{ $m->download_count ?? 0 }}</span></td>
                <td><span class="sc-badge {{ $m->status=='active'?'badge-success':'badge-secondary' }}">{{ ucfirst($m->status) }}</span></td>
                <td>
                    <div class="d-flex gap-1">
                        @if($m->file_path)<a href="{{ asset('uploads/materials/'.$m->file_path) }}" target="_blank" class="table-action-btn view"><i class="bi bi-download"></i></a>@endif
                        <form method="POST" action="{{ route('faculty.materials.destroy', $m) }}" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="table-action-btn delete" data-confirm="Delete this material?"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7">
                <div class="empty-state">
                    <div class="empty-icon"><i class="bi bi-file-earmark-x"></i></div>
                    <h4>No materials uploaded</h4>
                    <a href="{{ route('faculty.materials.create') }}" class="btn-primary-sc mt-3">Upload Material</a>
                </div>
            </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($materials->hasPages())
    <div class="card-body-sc pt-0">{{ $materials->withQueryString()->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
