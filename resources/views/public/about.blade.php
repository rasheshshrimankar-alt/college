@extends('layouts.public')
@section('title','About Us')
@section('meta_description','Learn about SMART CAMPUS College of Technology - 25+ years of academic excellence.')
@section('content')
<section style="padding:7rem 0 5rem;position:relative">
<div class="container-xl">
<div class="row g-5 align-items-center">
<div class="col-lg-6" style="animation:fadeInLeft .7s ease both">
<div class="section-label">About SMART CAMPUS</div>
<h1 class="section-title">Excellence in Education <span class="gradient-text">Since 1995</span></h1>
<p style="color:var(--text-muted);line-height:1.9;margin:1.25rem 0">SMART CAMPUS College of Technology is a premier institution dedicated to academic excellence, innovation, and holistic development. With state-of-the-art infrastructure and world-class faculty, we provide an exceptional learning environment that prepares students for global careers.</p>
<p style="color:var(--text-muted);line-height:1.9;margin-bottom:2rem">Our institution is NAAC A+ accredited and recognized as one of the top engineering colleges. We combine theoretical knowledge with practical skills through industry partnerships and research programs.</p>
<div class="row g-3">
@foreach([['25+','Years of Excellence','bi-clock'],['NAAC A+','Accreditation','bi-patch-check'],['95%','Placement Rate','bi-graph-up'],['50K+','Alumni Network','bi-people']] as [$val,$label,$icon])
<div class="col-6"><div class="sc-card" style="padding:1.25rem;display:flex;align-items:center;gap:.875rem"><div style="width:44px;height:44px;background:var(--gradient-1);border-radius:12px;display:flex;align-items:center;justify-content:center;color:white;font-size:1.1rem;flex-shrink:0"><i class="bi {{ $icon }}"></i></div><div><div style="font-size:1.2rem;font-weight:900;color:var(--text)">{{ $val }}</div><div style="font-size:.72rem;color:var(--text-muted);font-weight:600">{{ $label }}</div></div></div></div>
@endforeach
</div>
<a href="{{ route('admissions') }}" class="btn-primary-sc mt-4"><i class="bi bi-mortarboard me-2"></i>Apply Now</a>
</div>
<div class="col-lg-6" style="animation:fadeInRight .7s ease .2s both">
<div class="sc-card" style="padding:2.5rem;background:var(--gradient-1);color:white;border-radius:24px">
<h3 style="font-weight:800;margin-bottom:1.75rem">Why Choose SMART CAMPUS?</h3>
@foreach(['Expert PhD-qualified faculty with industry experience','State-of-the-art research labs and computing center','Strong industry partnerships with 200+ companies','Active student clubs, sports, and cultural activities','24/7 digital library with 50,000+ resources','Dedicated career cell with global placement support','Safe and vibrant campus with modern hostel facilities','Merit-based scholarships and financial assistance'] as $point)
<div class="d-flex align-items-center gap-2 mb-2"><div style="width:24px;height:24px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.8rem"><i class="bi bi-check-lg"></i></div><span style="font-size:.875rem;opacity:.9">{{ $point }}</span></div>
@endforeach
</div>
</div>
</div>
</div>
</section>
@endsection

