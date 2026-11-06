@extends('layouts.dashboard')
@section('title','Notices')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Notices</h1></div><a href="{{ route('admin.notices.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg"></i> Post Notice</a></div>
<div class="dashboard-card animate-slide-up">
<div class="sc-table-wrapper"><table class="sc-table"><thead><tr><th>Title</th><th>Category</th><th>Important</th><th>Published</th><th>Status</th><th>Actions</th></tr></thead><tbody>
@forelse($notices as $i => $n)
<tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
<td style="font-weight:600;font-size:.875rem">{{ Str::limit($n->title,45) }}</td>
<td><span class="sc-badge badge-info">{{ ucfirst($n->category) }}</span></td>
<td>@if($n->is_important)<span class="sc-badge badge-danger">Important</span>@else<span style="color:var(--text-muted);font-size:.8rem">—</span>@endif</td>
<td style="font-size:.78rem;color:var(--text-muted)">{{ \Carbon\Carbon::parse($n->publish_date)->format('d M Y') }}</td>
<td><span class="sc-badge {{ $n->status=='active'?'badge-success':'badge-secondary' }}">{{ ucfirst($n->status) }}</span></td>
<td><div class="d-flex gap-1"><a href="{{ route('admin.notices.edit',$n) }}" class="table-action-btn edit"><i class="bi bi-pencil"></i></a><form method="POST" action="{{ route('admin.notices.destroy',$n) }}" style="display:inline">@csrf @method('DELETE')<button class="table-action-btn delete" data-confirm="Delete notice?"><i class="bi bi-trash"></i></button></form></div></td>
</tr>
@empty<tr><td colspan="6"><div class="empty-state"><div class="empty-icon"><i class="bi bi-megaphone"></i></div><h4>No notices posted</h4><a href="{{ route('admin.notices.create') }}" class="btn-primary-sc mt-3">Post First Notice</a></div></td></tr>@endforelse
</tbody></table></div>
@if($notices->hasPages())<div class="card-body-sc pt-0">{{ $notices->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
