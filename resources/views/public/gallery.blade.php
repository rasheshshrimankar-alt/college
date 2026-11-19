@extends('layouts.public')
@section('title','Campus Gallery')
@section('meta_description','Explore campus life, facilities, events and student activities at SMART CAMPUS.')
@section('content')
<section style="padding:7rem 0 5rem"><div class="container-xl">
<div class="section-header text-center"><div class="section-label">Life at SMART CAMPUS</div><h1 class="section-title">Campus <span class="gradient-text">Gallery</span></h1><p class="text-muted">A glimpse into learning, creativity and community on campus.</p></div>
<form method="GET" class="dashboard-card mb-4"><div class="card-body-sc row g-2 align-items-center"><div class="col-md-8"><select name="category" class="sc-select"><option value="">All categories</option>@foreach($categories as $category)<option value="{{ $category }}" @selected(request('category')===$category)>{{ ucfirst($category) }}</option>@endforeach</select></div><div class="col-md-2"><button class="btn-primary-sc w-100">Filter</button></div><div class="col-md-2"><a class="btn-outline-sc w-100" href="{{ route('gallery') }}">Clear</a></div></div></form>
<div class="row g-3">@forelse($gallery as $photo)<div class="col-sm-6 col-lg-4"><figure class="sc-card h-100 overflow-hidden mb-0"><img src="{{ $photo->image_url }}" alt="{{ $photo->title }}" loading="lazy" style="width:100%;height:245px;object-fit:cover"><figcaption style="padding:1rem 1.15rem"><div class="d-flex justify-content-between gap-2"><strong>{{ $photo->title }}</strong>@if($photo->is_featured)<span class="sc-badge badge-primary">Featured</span>@endif</div>@if($photo->category)<small class="text-muted">{{ ucfirst($photo->category) }}</small>@endif @if($photo->description)<p class="small text-muted mt-2 mb-0">{{ $photo->description }}</p>@endif</figcaption></figure></div>@empty<div class="col-12"><div class="sc-card text-center p-5"><i class="bi bi-images fs-1 text-muted"></i><h2 class="h5 mt-3">Gallery is being updated</h2><p class="text-muted mb-0">Campus photographs will appear here when published.</p></div></div>@endforelse</div>
@if($gallery->hasPages())<div class="mt-4">{{ $gallery->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div></section>
@endsection
