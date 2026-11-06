@extends('layouts.dashboard')
@section('title','Page')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('content')<div class="page-header animate-fade-down"><div><h1 class="page-title">Page</h1></div></div><div class="dashboard-card animate-slide-up"><div class="card-body-sc text-center py-5"><div class="empty-icon mb-3"><i class="bi bi-gear"></i></div><h4>Coming Soon</h4><p style="color:var(--text-muted)">This module is being loaded.</p></div></div>@endsection
