@extends('layouts.dashboard')
@section('title','Fee Structure')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Fee Structure</h1></div></div>
<div class="row g-4">
<div class="col-lg-5 animate-slide-up anim-delay-1">
<div class="dashboard-card"><div class="card-header-sc"><h5><i class="bi bi-plus-lg me-2 text-primary-sc"></i>Add Fee Structure</h5></div><div class="card-body-sc">
<form method="POST" action="{{ route('admin.fees.structure.store') }}" data-validate>@csrf
<div class="row g-3">
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Course *</label><select name="course_id" class="sc-select" required><option value="">Select Course</option>@foreach($courses as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Fee Type *</label><select name="fee_type" class="sc-select" required><option value="tuition">Tuition</option><option value="hostel">Hostel</option><option value="transport">Transport</option><option value="exam">Examination</option><option value="library">Library</option><option value="other">Other</option></select></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Amount (₹) *</label><input type="number" name="amount" class="sc-input" required min="0"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Academic Year *</label><input type="text" name="academic_year" class="sc-input" value="{{ date('Y').'-'.substr(date('Y')+1,-2) }}" required></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Semester *</label><select name="semester" class="sc-select" required>@for($i=1;$i<=8;$i++)<option value="{{ $i }}">Sem {{ $i }}</option>@endfor</select></div></div>
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Due Date</label><input type="date" name="due_date" class="sc-input"></div></div>
</div>
<div class="mt-3"><button type="submit" class="btn-primary-sc w-100"><i class="bi bi-check-lg me-2"></i>Add Fee Structure</button></div>
</form></div></div>
</div>
<div class="col-lg-7 animate-slide-up anim-delay-2">
<div class="dashboard-card"><div class="card-header-sc"><h5>Current Fee Structures</h5></div>
<div class="sc-table-wrapper"><table class="sc-table">
<thead><tr><th>Course</th><th>Type</th><th>Amount</th><th>Semester</th><th>Year</th></tr></thead>
<tbody>@forelse($fees as $f)
<tr><td style="font-size:.85rem;font-weight:600">{{ Str::limit($f->course->name??'-',25) }}</td><td><span class="sc-badge badge-info">{{ ucfirst($f->fee_type) }}</span></td><td style="font-weight:700;color:var(--primary)">₹{{ number_format($f->amount) }}</td><td>Sem {{ $f->semester }}</td><td style="font-size:.78rem;color:var(--text-muted)">{{ $f->academic_year }}</td></tr>
@empty<tr><td colspan="5" class="text-center py-3" style="color:var(--text-muted)">No fee structures defined</td></tr>@endforelse</tbody>
</table></div>
@if($fees->hasPages())<div class="card-body-sc pt-0">{{ $fees->links('pagination::bootstrap-5') }}</div>@endif
</div>
</div>
</div>
@endsection
