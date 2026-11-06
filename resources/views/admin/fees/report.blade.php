@extends('layouts.dashboard')
@section('title','Fee Report')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Fee Report</h1></div></div>
<div class="dashboard-card animate-slide-up"><div class="sc-table-wrapper"><table class="sc-table">
<thead><tr><th>Student</th><th>Course</th><th>Total Paid</th><th>Fees Due</th><th>Status</th></tr></thead>
<tbody>@forelse($students as $s)
<tr>
<td><div style="font-weight:600;font-size:.875rem">{{ $s->user->name??'-' }}</div><div style="font-size:.72rem;color:var(--text-muted)">{{ $s->student_id }}</div></td>
<td style="font-size:.82rem">{{ Str::limit($s->course->name??'-',22) }}</td>
<td style="font-weight:700;color:var(--success)">₹{{ number_format($s->feePayments->where('status','paid')->sum('amount_paid')) }}</td>
<td style="font-weight:700;color:{{ $s->fees_due>0?'var(--danger)':'var(--success)' }}">{{ $s->fees_due>0?'₹'.number_format($s->fees_due):'Clear' }}</td>
<td><span class="sc-badge {{ $s->fees_due>0?'badge-danger':'badge-success' }}">{{ $s->fees_due>0?'Pending':'Cleared' }}</span></td>
</tr>
@empty<tr><td colspan="5"><div class="empty-state py-4"><div class="empty-icon"><i class="bi bi-cash"></i></div><h4>No data</h4></div></td></tr>@endforelse</tbody>
</table></div>
@if($students->hasPages())<div class="card-body-sc pt-0">{{ $students->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
