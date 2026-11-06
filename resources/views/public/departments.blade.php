@extends('layouts.public')
@section('title','Departments')
@section('content')
<section style="padding:7rem 0 5rem">
<div class="container-xl">
<div class="section-header"><div class="section-label">Academic Excellence</div><h1 class="section-title">Our <span class="gradient-text">Departments</span></h1></div>
<div class="row g-3">
@forelse($departments as $i => $dept)
<div class="col-md-6 col-lg-4" style="animation:fadeInUp .5s ease {{ $i*0.08 }}s both">
<div class="sc-card dept-card h-100" style="transition:all .3s" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='var(--shadow-lg)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='var(--shadow)'">
<div class="dept-icon"><i class="bi bi-building-fill"></i></div>
<h4>{{ $dept->name }}</h4><div class="dept-badge mb-2">{{ $dept->code }}</div>
<p>{{ Str::limit($dept->description ?? 'Quality education with industry-relevant curriculum.',100) }}</p>
<div class="d-flex justify-content-around mt-3" style="border-top:1px solid var(--border);padding-top:1rem">
<div class="text-center"><div style="font-size:1.3rem;font-weight:900;color:var(--primary)">{{ $dept->courses_count }}</div><div style="font-size:.7rem;color:var(--text-muted)">Courses</div></div>
<div class="text-center"><div style="font-size:1.3rem;font-weight:900;color:var(--secondary)">{{ $dept->faculty_count }}</div><div style="font-size:.7rem;color:var(--text-muted)">Faculty</div></div>
<div class="text-center"><div style="font-size:1.3rem;font-weight:900;color:var(--success)">{{ $dept->students_count }}</div><div style="font-size:.7rem;color:var(--text-muted)">Students</div></div>
</div>
@if($dept->head_name)<div style="font-size:.78rem;color:var(--text-muted);margin-top:.75rem;text-align:center"><i class="bi bi-person-fill me-1"></i>HOD: {{ $dept->head_name }}</div>@endif
<div class="text-center mt-3"><a href="{{ route('courses') }}?department={{ $dept->id }}" class="btn-outline-sc btn-sm-sc">View Courses <i class="bi bi-arrow-right ms-1"></i></a></div>
</div></div>
@empty<div class="col-12"><div class="empty-state"><div class="empty-icon"><i class="bi bi-building"></i></div><h4>No departments</h4></div></div>@endforelse
</div>
</div>
</section>
@endsection
