@extends('layouts.public')
@section('title','Faculty')
@section('content')
<section style="padding:6rem 0 4rem;background:var(--gradient-hero);color:white;text-align:center">
<div class="container-xl"><h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900">Our Faculty</h1><p style="opacity:.8;margin-top:.5rem">Expert educators shaping future leaders</p></div>
</section>
<section style="padding:5rem 0">
<div class="container-xl">
<form method="GET" class="row g-2 mb-5 justify-content-center">
<div class="col-md-4"><select name="department" class="sc-select" onchange="this.form.submit()"><option value="">All Departments</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ request('department')==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
@if(request('department'))<div class="col-md-2"><a href="{{ route('faculty') }}" class="btn-outline-sc w-100"><i class="bi bi-x-lg"></i> Clear</a></div>@endif
</form>
<div class="row g-4">
@forelse($faculty as $f)
<div class="col-md-6 col-lg-3">
<div class="sc-card text-center" style="padding:2rem;transition:all .3s" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='var(--shadow-lg)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow=''">
<img src="{{ $f->user->avatar_url }}" style="width:90px;height:90px;border-radius:50%;border:4px solid var(--primary-light);margin-bottom:1rem;object-fit:cover">
<h5 style="font-weight:700;font-size:.95rem;margin-bottom:.25rem">{{ $f->user->name }}</h5>
<div style="color:var(--primary);font-size:.8rem;font-weight:600;margin-bottom:.25rem">{{ $f->designation }}</div>
<div style="color:var(--text-muted);font-size:.78rem;margin-bottom:.75rem">{{ $f->department->name ?? '' }}</div>
@if($f->qualification)<span class="sc-badge badge-secondary" style="font-size:.65rem">{{ $f->qualification }}</span>@endif
@if($f->experience)<div style="margin-top:.5rem;font-size:.75rem;color:var(--text-muted)"><i class="bi bi-clock me-1"></i>{{ $f->experience }}</div>@endif
</div>
</div>
@empty
<div class="col-12 text-center"><div class="empty-state py-5"><div class="empty-icon"><i class="bi bi-person-badge"></i></div><h4>No faculty found</h4></div></div>
@endforelse
</div>
@if($faculty->hasPages())<div class="mt-4 d-flex justify-content-center">{{ $faculty->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div>
</section>
@endsection
