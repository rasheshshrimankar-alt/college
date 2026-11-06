@extends('layouts.public')
@section('title','Contact Us')
@section('content')
<section style="padding:7rem 0 5rem">
<div class="container-xl">
<div class="section-header"><div class="section-label">Get In Touch</div><h1 class="section-title">Contact <span class="gradient-text">Us</span></h1><p class="section-desc">Have questions? We would love to hear from you.</p></div>
<div class="row g-4">
<div class="col-lg-4">
<div class="row g-3">
@foreach([['bi-geo-alt-fill','Address','123 Education Park, Tech City, State - 400001'],['bi-phone-fill','Phone','+91 98765 43210 | +91 22 1234 5678'],['bi-envelope-fill','Email','info@smartcampus.edu | admissions@smartcampus.edu'],['bi-clock-fill','Office Hours','Mon-Fri: 9:00 AM - 5:00 PM']] as [$icon,$label,$val])
<div class="col-12" style="animation:fadeInLeft .5s ease both">
<div class="sc-card" style="padding:1.25rem;display:flex;gap:1rem;align-items:flex-start">
<div style="width:48px;height:48px;background:var(--gradient-1);border-radius:12px;display:flex;align-items:center;justify-content:center;color:white;font-size:1.1rem;flex-shrink:0"><i class="bi {{ $icon }}"></i></div>
<div><h6 style="font-weight:700;margin-bottom:.25rem">{{ $label }}</h6><p style="color:var(--text-muted);font-size:.82rem;margin:0">{{ $val }}</p></div>
</div></div>
@endforeach
</div>
</div>
<div class="col-lg-8" style="animation:fadeInRight .5s ease .2s both">
<div class="dashboard-card"><div class="card-header-sc"><h5><i class="bi bi-send me-2 text-primary-sc"></i>Send us a Message</h5></div><div class="card-body-sc">
@if(session('success'))<div class="sc-alert success mb-4"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>@endif
<form method="POST" action="{{ route('contact.submit') }}" data-validate>@csrf
<div class="row g-3">
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Full Name *</label><input type="text" name="name" class="sc-input @error('name') is-invalid @enderror" required placeholder="Your name" value="{{ old('name') }}"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Email *</label><input type="email" name="email" class="sc-input @error('email') is-invalid @enderror" required placeholder="your@email.com" value="{{ old('email') }}"></div></div>
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Subject *</label><input type="text" name="subject" class="sc-input @error('subject') is-invalid @enderror" required placeholder="How can we help you?" value="{{ old('subject') }}"></div></div>
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Message *</label><textarea name="message" class="sc-textarea @error('message') is-invalid @enderror" rows="5" required placeholder="Write your message here (min 20 characters)...">{{ old('message') }}</textarea></div></div>
</div>
<button type="submit" class="btn-primary-sc" style="padding:.75rem 2rem"><i class="bi bi-send me-2"></i>Send Message</button>
</form></div></div>
</div>
</div>
</div>
</section>
@endsection
