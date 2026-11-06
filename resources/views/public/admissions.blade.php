@extends('layouts.public')
@section('title','Admissions')
@section('content')
<section style="padding:7rem 0 5rem">
<div class="container-xl">
<div class="row g-5">
<div class="col-lg-7" style="animation:fadeInLeft .6s ease both">
<div class="section-label">Join SMART CAMPUS</div>
<h1 class="section-title">Apply for <span class="gradient-text">Admission {{ date('Y') }}</span></h1>
<p style="color:var(--text-muted);font-size:.95rem;line-height:1.75;margin-bottom:2rem">Start your journey to excellence. Applications for {{ date('Y') }}-{{ substr(date('Y')+1,-2) }} academic year are open. Fill in the form below.</p>
@if(session('success'))<div class="sc-alert success mb-4"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>@endif
<div class="dashboard-card"><div class="card-header-sc"><h5><i class="bi bi-person-plus me-2 text-primary-sc"></i>Admission Application</h5></div><div class="card-body-sc">
<form method="POST" action="{{ route('admission.submit') }}" data-validate>@csrf
<div class="row g-3">
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Full Name *</label><input type="text" name="applicant_name" class="sc-input" required placeholder="Your full name"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Email *</label><input type="email" name="applicant_email" class="sc-input" required placeholder="email@example.com"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Phone *</label><input type="text" name="applicant_phone" class="sc-input" required placeholder="10-digit number"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Course *</label><select name="course_id" class="sc-select" required><option value="">Select Course</option>@foreach($courses as $c)<option value="{{ $c->id }}" {{ request('course')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Qualification *</label><select name="previous_qualification" class="sc-select" required><option value="">Select</option><option>10+2 / HSC</option><option>Diploma</option><option>Graduation</option><option>Post-Graduation</option></select></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Percentage *</label><input type="number" name="previous_percentage" class="sc-input" min="0" max="100" step="0.01" required placeholder="e.g. 85.5"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Guardian Name</label><input type="text" name="guardian_name" class="sc-input" placeholder="Parent/Guardian name"></div></div>
<div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Guardian Phone</label><input type="text" name="guardian_phone" class="sc-input"></div></div>
<div class="col-12"><div class="sc-form-group"><label class="sc-label">Address</label><textarea name="address" class="sc-textarea" rows="2" placeholder="Full residential address"></textarea></div></div>
</div>
<button type="submit" class="btn-primary-sc w-100 mt-2" style="padding:.875rem;font-weight:700"><i class="bi bi-send me-2"></i>Submit Application — Free</button>
</form></div></div>
</div>
<div class="col-lg-5" style="animation:fadeInRight .6s ease .2s both">
<div class="sc-card" style="padding:2rem;background:var(--gradient-1);color:white;border-radius:20px;position:sticky;top:5.5rem">
<h4 style="font-weight:800;margin-bottom:1.5rem">🎓 Why SMART CAMPUS?</h4>
@foreach(['₹7.5 LPA Average Package','95% Placement Rate','25+ Years of Excellence','NAAC A+ Accreditation','Expert PhD Faculty','World-class Infrastructure','Active Research Programs','100+ Student Clubs & Activities'] as $point)
<div class="d-flex align-items-center gap-2 mb-2"><div style="width:22px;height:22px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.7rem"><i class="bi bi-check-lg"></i></div><span style="font-size:.875rem;opacity:.9">{{ $point }}</span></div>
@endforeach
<div style="border-top:1px solid rgba(255,255,255,.2);padding-top:1.25rem;margin-top:1.25rem">
<div style="font-size:.82rem;opacity:.8">Need help? Call our Admission Helpline</div>
<div style="font-size:1.3rem;font-weight:800;margin-top:.25rem">+91 98765 43210</div>
<div style="font-size:.78rem;opacity:.7;margin-top:.2rem">Mon-Sat, 9AM to 6PM</div>
</div>
</div>
</div>
</div>
</div>
</section>
@endsection

