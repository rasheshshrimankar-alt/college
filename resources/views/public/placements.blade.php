@extends('layouts.public')
@section('title','Placements')
@section('content')
<section style="padding:7rem 0 5rem">
<div class="container-xl">
<div class="section-header"><div class="section-label">Career Success</div><h1 class="section-title">Placement <span class="gradient-text">Excellence</span></h1></div>
<div class="row g-3 mb-5">
@foreach([['₹'.number_format($stats['max_package'],1).' LPA','Highest Package','bi-trophy-fill','blue'],['₹'.number_format($stats['avg_package'],1).' LPA','Average Package','bi-graph-up-arrow','green'],[$stats['total'].'+','Students Placed','bi-people-fill','purple'],[$stats['companies'].'+','Hiring Companies','bi-building-fill','orange']] as [$val,$label,$icon,$color])
<div class="col-6 col-lg-3" style="animation:fadeInUp .5s ease both">
<div class="sc-card stat-card"><div class="stat-icon {{ $color }}"><i class="bi {{ $icon }}"></i></div><div class="stat-info"><span class="stat-num">{{ $val }}</span><span class="stat-label">{{ $label }}</span></div></div>
</div>
@endforeach
</div>
<div class="row g-3">
@forelse($placements as $i => $p)
<div class="col-md-6 col-lg-4" style="animation:fadeInUp .5s ease {{ $i*0.07 }}s both">
<div class="sc-card" style="padding:1.25rem;transition:all .3s" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
<div class="d-flex align-items-center gap-3 mb-2">
<img src="{{ $p->student->user->avatar_url }}" style="width:46px;height:46px;border-radius:50%;border:2px solid var(--primary-light)" alt="">
<div><div style="font-weight:700;font-size:.9rem">{{ $p->student->user->name ?? 'Student' }}</div><div style="font-size:.75rem;color:var(--text-muted)">{{ Str::limit($p->student->course->name ?? '',25) }}</div></div>
</div>
<div style="background:var(--gradient-1);border-radius:10px;padding:.75rem;color:white;text-align:center;margin-bottom:.75rem">
<div style="font-size:.7rem;opacity:.8;margin-bottom:.1rem">Package</div>
<div style="font-size:1.6rem;font-weight:900">₹{{ $p->package_lpa }} LPA</div>
</div>
<div style="font-weight:700;font-size:.9rem;margin-bottom:.15rem">{{ $p->company_name }}</div>
<div style="font-size:.78rem;color:var(--text-muted);margin-bottom:.5rem">{{ $p->position }}</div>
<div class="d-flex justify-content-between align-items-center">
<span class="sc-badge badge-info" style="font-size:.62rem">{{ ucfirst($p->placement_type) }}</span>
<span style="font-size:.72rem;color:var(--text-muted)">{{ $p->academic_year }}</span>
</div>
</div>
</div>
@empty<div class="col-12"><div class="empty-state"><div class="empty-icon"><i class="bi bi-briefcase"></i></div><h4>No placements yet</h4></div></div>@endforelse
</div>
@if($placements->hasPages())<div class="mt-4 text-center">{{ $placements->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div>
</section>
@endsection
