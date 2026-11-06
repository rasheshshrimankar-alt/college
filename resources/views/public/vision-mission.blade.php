@extends('layouts.public')
@section('title','Vision & Mission')
@section('content')
<section style="padding:6rem 0 4rem;background:var(--gradient-hero);color:white;text-align:center">
<div class="container-xl"><h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900">Vision & Mission</h1><p style="opacity:.8;margin-top:.5rem">Our guiding principles for academic excellence</p></div>
</section>
<section style="padding:5rem 0">
<div class="container-xl">
<div class="row g-4 mb-5">
<div class="col-lg-6">
<div class="sc-card" style="padding:2.5rem;height:100%;border-left:4px solid var(--primary)">
<div style="width:64px;height:64px;background:var(--gradient-1);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.8rem;color:white;margin-bottom:1.5rem"><i class="bi bi-eye"></i></div>
<h2 style="font-weight:800;margin-bottom:1rem;color:var(--primary)">Our Vision</h2>
<p style="font-size:1rem;line-height:1.8;color:var(--text-muted)">To be a globally recognized institution of excellence that nurtures innovative thinkers, ethical leaders, and responsible citizens who contribute meaningfully to society and industry through cutting-edge education, research, and technology.</p>
</div>
</div>
<div class="col-lg-6">
<div class="sc-card" style="padding:2.5rem;height:100%;border-left:4px solid var(--secondary)">
<div style="width:64px;height:64px;background:linear-gradient(135deg,var(--secondary),var(--accent));border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.8rem;color:white;margin-bottom:1.5rem"><i class="bi bi-bullseye"></i></div>
<h2 style="font-weight:800;margin-bottom:1rem;color:var(--secondary)">Our Mission</h2>
<p style="font-size:1rem;line-height:1.8;color:var(--text-muted)">To provide quality technical and management education that empowers students with theoretical knowledge, practical skills, and ethical values — preparing them to meet global challenges and contribute to national development through innovation and research.</p>
</div>
</div>
</div>
<h2 style="font-weight:800;text-align:center;margin-bottom:2rem">Core <span style="background:var(--gradient-1);-webkit-background-clip:text;-webkit-text-fill-color:transparent">Values</span></h2>
<div class="row g-3">
@foreach([['bi-patch-check','Excellence','We pursue the highest standards in everything we do.','var(--primary)'],['bi-lightbulb','Innovation','We foster creative thinking and cutting-edge research.','var(--secondary)'],['bi-people','Integrity','We uphold honesty, ethics, and transparency.','var(--success)'],['bi-globe','Inclusivity','We welcome and celebrate diversity in all forms.','var(--warning)'],['bi-tree','Sustainability','We act responsibly for present and future generations.','var(--accent)'],['bi-award','Leadership','We inspire students to lead with vision and purpose.','var(--danger)']] as [$icon,$title,$desc,$color])
<div class="col-md-4">
<div class="sc-card" style="padding:1.75rem;text-align:center;transition:all .3s" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
<div style="width:56px;height:56px;background:{{ $color }}18;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:{{ $color }};margin:0 auto 1rem"><i class="bi {{ $icon }}"></i></div>
<h5 style="font-weight:700;margin-bottom:.5rem">{{ $title }}</h5>
<p style="font-size:.85rem;color:var(--text-muted);margin:0">{{ $desc }}</p>
</div>
</div>
@endforeach
</div>
</div>
</section>
@endsection
