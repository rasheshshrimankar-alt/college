@extends('layouts.public')
@section('title','Campus News')
@section('meta_description','Latest news, announcements and achievements from SMART CAMPUS.')
@section('content')
<section style="padding:7rem 0 5rem"><div class="container-xl">
<div class="section-header text-center"><div class="section-label">What's Happening</div><h1 class="section-title">Campus <span class="gradient-text">News</span></h1><p class="text-muted">Stories, achievements and updates from our campus.</p></div>
<form method="GET" class="dashboard-card mb-4"><div class="card-body-sc row g-2 align-items-center"><div class="col-md-8"><select name="category" class="sc-select"><option value="">All categories</option>@foreach($news->pluck('category')->filter()->unique() as $category)<option value="{{ $category }}" @selected(request('category')===$category)>{{ ucfirst($category) }}</option>@endforeach</select></div><div class="col-md-2"><button class="btn-primary-sc w-100">Filter</button></div><div class="col-md-2"><a class="btn-outline-sc w-100" href="{{ route('news') }}">Clear</a></div></div></form>
<div class="row g-4">@forelse($news as $item)<div class="col-md-6 col-lg-4"><article class="sc-card h-100 overflow-hidden">
@if($item->image)<img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="lazy" style="width:100%;height:210px;object-fit:cover">@else<div style="height:170px;background:var(--gradient-1);display:grid;place-items:center;color:white;font-size:3rem"><i class="bi bi-newspaper"></i></div>@endif
<div style="padding:1.35rem"><div class="d-flex justify-content-between gap-2 mb-2"><span class="sc-badge badge-primary">{{ ucfirst($item->category ?? 'Campus') }}</span><small class="text-muted">{{ $item->created_at?->format('d M Y') }}</small></div><h2 class="h5" style="font-weight:800">{{ $item->title }}</h2><p class="text-muted small mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($item->content),150) }}</p></div>
</article></div>@empty<div class="col-12"><div class="sc-card text-center p-5"><i class="bi bi-newspaper fs-1 text-muted"></i><h2 class="h5 mt-3">No news published yet</h2><p class="text-muted mb-0">Please check back for campus updates.</p></div></div>@endforelse</div>
@if($news->hasPages())<div class="mt-4">{{ $news->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div></section>
@endsection
