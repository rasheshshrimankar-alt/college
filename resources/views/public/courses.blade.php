@extends('layouts.public')
@section('title','Courses')
@section('content')
<section style="padding:7rem 0 5rem">
<div class="container-xl">
<div class="section-header"><div class="section-label">Academic Programs</div><h1 class="section-title">Explore Our <span class="gradient-text">Courses</span></h1></div>
<div class="dashboard-card mb-5" style="animation:fadeInDown .5s ease both">
<div class="card-body-sc"><form method="GET" class="row g-2 align-items-center">
<div class="col-md-5"><select name="department" class="sc-select"><option value="">All Departments</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ request('department')==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
<div class="col-md-3"><button type="submit" class="btn-primary-sc btn-sm-sc w-100"><i class="bi bi-funnel me-1"></i>Filter</button></div>
<div class="col-md-3"><a href="{{ route('courses') }}" class="btn-outline-sc btn-sm-sc w-100">Clear All</a></div>
</form></div></div>
<div class="row g-3">
@forelse($courses as $i => $course)
<div class="col-md-6 col-lg-4" style="animation:fadeInUp .5s ease {{ $i*0.07 }}s both">
<div class="sc-card h-100" style="padding:1.5rem;transition:all .3s" onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='var(--shadow-lg)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='var(--shadow)'">
<div class="d-flex justify-content-between align-items-start mb-3"><div style="width:52px;height:52px;background:var(--gradient-1);border-radius:14px;display:flex;align-items:center;justify-content:center;color:white;font-size:1.3rem"><i class="bi bi-book-fill"></i></div><span class="sc-badge badge-info">{{ $course->duration_years }} Yrs</span></div>
<h5 style="font-weight:700;font-size:.95rem;margin-bottom:.4rem">{{ $course->name }}</h5>
<div style="font-size:.78rem;color:var(--primary);font-weight:600;margin-bottom:.75rem">{{ $course->department->name ?? '' }}</div>
<p style="font-size:.82rem;color:var(--text-muted);margin-bottom:1rem">{{ Str::limit($course->description ?? 'Industry-oriented curriculum with hands-on training and internship opportunities.',110) }}</p>
<div class="d-flex justify-content-between" style="font-size:.78rem;border-top:1px solid var(--border);padding-top:.75rem"><span style="color:var(--text-muted)"><i class="bi bi-people me-1"></i>{{ $course->total_seats }} seats</span><span style="color:var(--text-muted)"><i class="bi bi-calendar me-1"></i>{{ $course->total_semesters }} sem</span><span style="font-weight:700;color:var(--success)">₹{{ number_format($course->fees_per_semester) }}/sem</span></div>
<a href="{{ route('admissions') }}?course={{ $course->id }}" class="btn-primary-sc w-100 mt-3" style="justify-content:center">Apply Now <i class="bi bi-arrow-right ms-1"></i></a>
</div></div>
@empty<div class="col-12"><div class="empty-state"><div class="empty-icon"><i class="bi bi-book"></i></div><h4>No courses found</h4></div></div>@endforelse
</div>
@if($courses->hasPages())<div class="mt-4 text-center">{{ $courses->withQueryString()->links('pagination::bootstrap-5') }}</div>@endif
</div>
</section>
@endsection
