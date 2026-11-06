@extends('layouts.dashboard')
@section('title','Faculty Profile')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Faculty Profile</h1></div><div class="d-flex gap-2"><a href="{{ route('admin.faculty.edit',$faculty) }}" class="btn-primary-sc btn-sm-sc"><i class="bi bi-pencil"></i> Edit</a><a href="{{ route('admin.faculty.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a></div></div>
<div class="row g-4">
<div class="col-lg-4 animate-slide-up anim-delay-1">
<div class="dashboard-card text-center">
<div class="card-body-sc">
<img src="{{ $faculty->user->avatar_url }}" style="width:100px;height:100px;border-radius:50%;border:4px solid var(--primary-light);margin-bottom:1rem">
<h4 style="font-weight:800;margin-bottom:.25rem">{{ $faculty->user->name }}</h4>
<div style="color:var(--primary);font-size:.875rem;font-weight:600;margin-bottom:.25rem">{{ $faculty->designation }}</div>
<div style="color:var(--text-muted);font-size:.82rem;margin-bottom:1rem">{{ $faculty->department->name ?? '' }}</div>
<div class="d-flex flex-wrap gap-2 justify-content-center mb-3"><span class="sc-badge badge-primary">{{ $faculty->faculty_id }}</span><span class="sc-badge badge-secondary">{{ $faculty->status }}</span></div>
<div style="text-align:left;border-top:1px solid var(--border);padding-top:1rem">
@foreach([['bi-envelope','Email',$faculty->user->email],['bi-phone','Phone',$faculty->user->phone??'N/A'],['bi-award','Qualification',$faculty->qualification??'N/A'],['bi-lightbulb','Specialization',$faculty->specialization??'N/A'],['bi-briefcase','Experience',$faculty->experience??'N/A'],['bi-currency-rupee','Salary','₹'.number_format($faculty->salary??0)]] as [$icon,$label,$val])
<div class="d-flex gap-2 mb-2"><i class="bi {{ $icon }}" style="color:var(--primary);margin-top:2px;flex-shrink:0"></i><div><span style="font-size:.72rem;color:var(--text-muted);display:block">{{ $label }}</span><span style="font-size:.85rem;font-weight:500">{{ $val }}</span></div></div>
@endforeach
</div>
</div>
</div>
</div>
<div class="col-lg-8 animate-slide-up anim-delay-2">
<div class="dashboard-card">
<div class="card-header-sc"><h5><i class="bi bi-book me-2 text-primary-sc"></i>Assigned Subjects</h5></div>
<div class="sc-table-wrapper"><table class="sc-table">
<thead><tr><th>Subject</th><th>Code</th><th>Course</th><th>Semester</th><th>Credits</th></tr></thead>
<tbody>@forelse($faculty->subjects as $s)
<tr><td style="font-weight:600;font-size:.875rem">{{ $s->name }}</td><td><code style="font-size:.75rem;color:var(--primary)">{{ $s->code }}</code></td><td style="font-size:.82rem">{{ $s->course->name??'-' }}</td><td><span class="sc-badge badge-info">Sem {{ $s->semester }}</span></td><td>{{ $s->credits }}</td></tr>
@empty<tr><td colspan="5" class="text-center py-3" style="color:var(--text-muted)">No subjects assigned</td></tr>@endforelse</tbody>
</table></div>
</div>
</div>
</div>
@endsection
