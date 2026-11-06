@extends('layouts.dashboard')
@section('title','Student Details')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
<div><h1 class="page-title">{{ $student->user->name }}</h1><span class="sc-badge badge-primary">{{ $student->student_id }}</span></div>
<div class="d-flex gap-2"><a href="{{ route('admin.students.edit',$student) }}" class="btn-primary-sc btn-sm-sc"><i class="bi bi-pencil"></i> Edit</a><a href="{{ route('admin.students.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div>
</div>
<div class="row g-3">
<div class="col-lg-4 animate-slide-up anim-delay-1">
<div class="dashboard-card text-center">
<div class="card-body-sc">
<img src="{{ $student->user->avatar_url }}" style="width:90px;height:90px;border-radius:50%;border:4px solid var(--primary-light);margin-bottom:1rem" alt="">
<h4 style="font-weight:800;font-size:1.05rem">{{ $student->user->name }}</h4>
<div style="font-size:.82rem;color:var(--text-muted)">{{ $student->user->email }}</div>
<span class="sc-badge {{ $student->status=='active'?'badge-success':'badge-secondary' }} mt-2 d-inline-block">{{ ucfirst($student->status) }}</span>
<div class="mt-3 text-start" style="border-top:1px solid var(--border);padding-top:1rem">
@foreach([['Roll No.',$student->roll_number],['Course',Str::limit($student->course->name ?? '-',18)],['Department',$student->department->code ?? '-'],['Semester','Sem '.($student->current_semester ?? '-')],['Batch',$student->batch_year],['Blood Group',$student->blood_group ?? '-'],['Guardian',$student->guardian_name ?? '-'],['Phone',$student->user->phone ?? '-']] as [$label,$val])
<div class="d-flex justify-content-between mb-2" style="font-size:.82rem"><span style="color:var(--text-muted)">{{ $label }}</span><strong>{{ $val }}</strong></div>
@endforeach
<div class="d-flex justify-content-between" style="font-size:.82rem"><span style="color:var(--text-muted)">Fees Due</span><strong style="color:{{ $student->fees_due>0?'var(--danger)':'var(--success)' }}">{{ $student->fees_due>0?'₹'.number_format($student->fees_due):'Clear' }}</strong></div>
</div>
</div>
</div>
</div>
<div class="col-lg-8">
<div class="dashboard-card mb-3 animate-slide-up anim-delay-2">
<div class="card-header-sc"><h5><i class="bi bi-graph-up me-2 text-primary-sc"></i>Recent Results</h5></div>
<div class="sc-table-wrapper"><table class="sc-table"><thead><tr><th>Subject</th><th>Exam</th><th>Marks</th><th>%</th><th>Grade</th></tr></thead><tbody>
@forelse($student->results->take(6) as $r)
<tr><td style="font-size:.85rem">{{ $r->subject->name ?? '-' }}</td><td style="font-size:.78rem;color:var(--text-muted)">{{ Str::limit($r->examination->name ?? '-',25) }}</td><td style="font-weight:600">{{ $r->marks_obtained }}/{{ $r->total_marks }}</td><td style="font-weight:700;color:{{ $r->percentage>=75?'var(--success)':($r->percentage>=40?'var(--warning)':'var(--danger)') }}">{{ number_format($r->percentage,1) }}%</td><td><span class="sc-badge {{ $r->status=='pass'?'badge-success':'badge-danger' }}">{{ $r->grade ?? ucfirst($r->status) }}</span></td></tr>
@empty<tr><td colspan="5" class="text-center py-3" style="color:var(--text-muted)">No results yet</td></tr>@endforelse
</tbody></table></div>
</div>
<div class="dashboard-card animate-slide-up anim-delay-3">
<div class="card-header-sc"><h5><i class="bi bi-cash me-2 text-primary-sc"></i>Fee Payments</h5></div>
<div class="sc-table-wrapper"><table class="sc-table"><thead><tr><th>Receipt</th><th>Amount</th><th>Method</th><th>Date</th></tr></thead><tbody>
@forelse($student->feePayments->take(5) as $p)
<tr><td><code style="font-size:.72rem;color:var(--primary)">{{ $p->receipt_number }}</code></td><td style="font-weight:700;color:var(--success)">₹{{ number_format($p->amount_paid) }}</td><td><span class="sc-badge badge-info">{{ ucfirst($p->payment_method) }}</span></td><td style="font-size:.78rem;color:var(--text-muted)">{{ \Carbon\Carbon::parse($p->payment_date)->format('d M Y') }}</td></tr>
@empty<tr><td colspan="4" class="text-center py-3" style="color:var(--text-muted)">No payments</td></tr>@endforelse
</tbody></table></div>
</div>
</div>
</div>
@endsection
