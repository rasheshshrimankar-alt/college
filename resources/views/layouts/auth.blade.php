<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Login') | SMART CAMPUS</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ asset('css/smartcampus.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@700;800&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.4/gsap.min.js"></script>
<style>
.auth-wrapper{min-height:100vh;display:flex;position:relative;overflow:hidden}
.auth-left{flex:1;background:var(--gradient-1);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:3rem;position:relative;overflow:hidden}
.auth-right{width:480px;min-height:100vh;background:var(--card);display:flex;flex-direction:column;justify-content:center;padding:3rem;overflow-y:auto;flex-shrink:0}
@media(max-width:768px){.auth-left{display:none}.auth-right{width:100vw;padding:2rem 1.5rem}}
.auth-shape{position:absolute;border-radius:50%;background:rgba(255,255,255,.08)}
.auth-brand-text{font-family:'Poppins',sans-serif;font-size:2.4rem;font-weight:800;color:white;line-height:1.1}
.auth-logo{width:72px;height:72px;background:rgba(255,255,255,.2);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:900;color:white;font-family:'Poppins',sans-serif;margin-bottom:1.5rem;backdrop-filter:blur(10px);border:2px solid rgba(255,255,255,.3)}
.auth-feature{display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem}
.auth-feature-icon{width:48px;height:48px;background:rgba(255,255,255,.15);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0}
.auth-feature-text h6{color:white;font-weight:700;margin-bottom:.2rem;font-size:.95rem}
.auth-feature-text p{color:rgba(255,255,255,.75);font-size:.8rem;margin:0}
.auth-title{font-family:'Poppins',sans-serif;font-size:1.75rem;font-weight:800;color:var(--text);margin-bottom:.5rem}
.auth-subtitle{color:var(--text-muted);font-size:.875rem;margin-bottom:2rem}
.auth-divider{display:flex;align-items:center;gap:1rem;margin:1.5rem 0}
.auth-divider::before,.auth-divider::after{content:'';flex:1;height:1px;background:var(--border)}
.auth-divider span{font-size:.75rem;color:var(--text-muted);font-weight:600;white-space:nowrap}
.floating-card{position:absolute;background:rgba(255,255,255,.12);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,.2);border-radius:16px;padding:1rem 1.25rem;color:white}
</style>
</head>
<body>
<div class="auth-wrapper">
    <!-- Left Panel -->
    <div class="auth-left">
        <!-- Background shapes -->
        <div class="auth-shape" style="width:400px;height:400px;top:-150px;right:-100px;animation:float 8s ease-in-out infinite alternate"></div>
        <div class="auth-shape" style="width:250px;height:250px;bottom:-80px;left:-60px;animation:float 6s ease-in-out 2s infinite alternate"></div>
        <div class="auth-shape" style="width:150px;height:150px;top:30%;right:10%;animation:float 7s ease-in-out 1s infinite alternate"></div>

        <!-- Floating cards -->
        <div class="floating-card" style="top:12%;right:8%;animation:float 4s ease-in-out infinite alternate">
            <div style="font-size:.7rem;opacity:.7;margin-bottom:.3rem">Total Students</div>
            <div style="font-size:1.6rem;font-weight:800">1,250+</div>
        </div>
        <div class="floating-card" style="bottom:18%;left:5%;animation:float 5s ease-in-out .5s infinite alternate">
            <div style="font-size:.7rem;opacity:.7;margin-bottom:.3rem">Avg Placement</div>
            <div style="font-size:1.3rem;font-weight:800">₹7.5 LPA</div>
        </div>

        <div style="position:relative;z-index:2;width:100%;max-width:400px">
            <div class="auth-logo">S</div>
            <div class="auth-brand-text mb-1">SMART<br>CAMPUS</div>
            <div style="color:rgba(255,255,255,.75);font-size:.9rem;margin-bottom:2.5rem">College of Technology</div>
            <div class="auth-feature"><div class="auth-feature-icon"><i class="bi bi-graph-up-arrow"></i></div><div class="auth-feature-text"><h6>Academic Excellence</h6><p>Track grades, attendance, and results in real time</p></div></div>
            <div class="auth-feature"><div class="auth-feature-icon"><i class="bi bi-people-fill"></i></div><div class="auth-feature-text"><h6>Collaborative Learning</h6><p>Assignments, materials, and faculty interaction</p></div></div>
            <div class="auth-feature"><div class="auth-feature-icon"><i class="bi bi-shield-check"></i></div><div class="auth-feature-text"><h6>Secure & Reliable</h6><p>Role-based access with enterprise-grade security</p></div></div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="auth-right">
        <!-- Theme toggle -->
        <div style="position:absolute;top:1.5rem;right:1.5rem">
            <button class="nav-action-btn border-0" data-theme-toggle style="background:var(--bg)"><i class="bi bi-moon"></i></button>
        </div>
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/smartcampus.js') }}"></script>
<script>
gsap.timeline({defaults:{ease:'power3.out'}})
    .from('.auth-logo',{y:30,opacity:0,duration:.6,delay:.2})
    .from('.auth-brand-text',{y:20,opacity:0,duration:.6},'-=.3')
    .from('.auth-feature',{y:20,opacity:0,stagger:.15,duration:.5},'-=.3')
    .from('.auth-title',{y:20,opacity:0,duration:.5},'-=.6')
    .from('.auth-subtitle',{y:15,opacity:0,duration:.4},'-=.3')
    .from('.sc-form-group',{y:15,opacity:0,stagger:.1,duration:.4},'-=.2');
</script>
@stack('scripts')
</body>
</html>
