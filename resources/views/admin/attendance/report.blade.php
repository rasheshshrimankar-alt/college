@extends('layouts.dashboard')
@section('title','Attendance Report')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Attendance Report</h1></div></div>
<div class="dashboard-card animate-slide-up"><div class="card-body-sc text-center py-5"><div class="empty-icon mb-3"><i class="bi bi-file-earmark-bar-graph"></i></div><h4>Attendance Report</h4><p style="color:var(--text-muted)">Detailed attendance analytics available in the <a href="{{ route('admin.reports.index') }}" style="color:var(--primary)">Reports</a> section.</p><a href="{{ route('admin.reports.index') }}" class="btn-primary-sc mt-3">Go to Reports</a></div></div>
@endsection
