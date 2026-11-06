@extends('layouts.dashboard')
@section('title','Scholarships')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Scholarships</h1></div><a href="{{ route('admin.scholarships.create') }}" class="btn-primary-sc"><i class="bi bi-plus-lg"></i> Add</a></div>
<div class="dashboard-card animate-slide-up"><div class="sc-table-wrapper"><table class="sc-table">
<thead><tr><th>#</th><th>Name</th><th>Provider</th><th>Amount</th><th>Deadline</th><th>Status</th><th>Actions</th></tr></thead>
<tbody>@forelse($scholarships as $i => $s)
<tr style="animation:fadeInLeft .4s ease {{ $i*0.04 }}s both">
<td style="color:var(--text-muted);font-size:.78rem">{{ $scholarships->firstItem()+$i }}</td>
<td><div style="font-weight:600;font-size:.875rem">{{ $s->name }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ Str::limit($s->eligibility,50) }}</div></td>
<td style="font-size:.82rem">{{ $s->provider }}</td>
<td style="font-weight:700;color:var(--success)">₹{{ number_format($s->amount) }}/yr</td>
<td style="font-size:.82rem;color:{{ $s->application_deadline && now()->gt($s->application_deadline)?'var(--danger)':'var(--text-muted)' }}">{{ $s->application_deadline ? \Carbon\Carbon::parse($s->application_deadline)->format('d M Y') : '—' }}</td>
<td><span class="sc-badge {{ $s->status=='active'?'badge-success':'badge-secondary' }}">{{ ucfirst($s->status) }}</span></td>
<td><div class="d-flex gap-1"><a href="{{ route('admin.scholarships.edit',$s) }}" class="table-action-btn edit"><i class="bi bi-pencil"></i></a><form method="POST" action="{{ route('admin.scholarships.destroy',$s) }}" style="display:inline">@csrf @method('DELETE')<button class="table-action-btn delete" data-confirm="Delete?"><i class="bi bi-trash"></i></button></form></div></td>
</tr>
@empty<tr><td colspan="7"><div class="empty-state"><div class="empty-icon"><i class="bi bi-award"></i></div><h4>No scholarships</h4><a href="{{ route('admin.scholarships.create') }}" class="btn-primary-sc mt-3">Add Scholarship</a></div></td></tr>@endforelse</tbody>
</table></div>
@if($scholarships->hasPages())<div class="card-body-sc pt-0">{{ $scholarships->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
