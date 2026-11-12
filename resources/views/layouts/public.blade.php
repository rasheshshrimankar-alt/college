<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'SMART CAMPUS College of Technology – Premium Education for a Better Future')">
    <title>@yield('title', 'SMART CAMPUS') | SMART CAMPUS College of Technology</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SMART CAMPUS CSS -->
    <link rel="stylesheet" href="{{ secure_asset('css/smartcampus.css') }}">
    @stack('styles')
</head>
<body>

<!-- Page Loader -->
<div class="page-loader" id="pageLoader">
    <div class="text-center">
        <div class="sc-spinner mx-auto mb-3"></div>
        <div style="font-size:.8rem;color:var(--text-muted);font-weight:600;">SMART CAMPUS</div>
    </div>
</div>

<!-- Navbar -->
<nav class="sc-navbar">
    <div class="container-xl">
        <div class="d-flex align-items-center justify-content-between w-100">
            <!-- Brand -->
            <a href="{{ route('home') }}" class="navbar-brand text-decoration-none">
                <div class="d-flex align-items-center gap-2">
                    <div class="brand-logo">S</div>
                    <div>
                        <div class="brand-name">SMART<span>CAMPUS</span></div>
                        <div style="font-size:.6rem;color:var(--text-muted);letter-spacing:.5px;line-height:1">College of Technology</div>
                    </div>
                </div>
            </a>

            <!-- Desktop Nav -->
            <div class="d-none d-xl-flex align-items-center gap-1">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">About</a>
                    <ul class="dropdown-menu border-0 shadow-lg" style="border-radius:12px;min-width:200px;padding:.5rem;">
                        <li><a class="dropdown-item" href="{{ route('about') }}" style="border-radius:8px;font-size:.85rem;">About College</a></li>
                        <li><a class="dropdown-item" href="{{ route('principal') }}" style="border-radius:8px;font-size:.85rem;">Principal's Message</a></li>
                        <li><a class="dropdown-item" href="{{ route('vision-mission') }}" style="border-radius:8px;font-size:.85rem;">Vision & Mission</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Academics</a>
                    <ul class="dropdown-menu border-0 shadow-lg" style="border-radius:12px;min-width:200px;padding:.5rem;">
                        <li><a class="dropdown-item" href="{{ route('departments') }}" style="border-radius:8px;font-size:.85rem;">Departments</a></li>
                        <li><a class="dropdown-item" href="{{ route('courses') }}" style="border-radius:8px;font-size:.85rem;">Courses</a></li>
                        <li><a class="dropdown-item" href="{{ route('faculty') }}" style="border-radius:8px;font-size:.85rem;">Faculty</a></li>
                        <li><a class="dropdown-item" href="{{ route('library') }}" style="border-radius:8px;font-size:.85rem;">Library</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Admissions</a>
                    <ul class="dropdown-menu border-0 shadow-lg" style="border-radius:12px;min-width:200px;padding:.5rem;">
                        <li><a class="dropdown-item" href="{{ route('admissions') }}" style="border-radius:8px;font-size:.85rem;">Admission Process</a></li>
                        <li><a class="dropdown-item" href="{{ route('scholarships') }}" style="border-radius:8px;font-size:.85rem;">Scholarships</a></li>
                        <li><a class="dropdown-item" href="{{ route('placements') }}" style="border-radius:8px;font-size:.85rem;">Placements</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Campus</a>
                    <ul class="dropdown-menu border-0 shadow-lg" style="border-radius:12px;min-width:200px;padding:.5rem;">
                        <li><a class="dropdown-item" href="{{ route('events') }}" style="border-radius:8px;font-size:.85rem;">Events</a></li>
                        <li><a class="dropdown-item" href="{{ route('news') }}" style="border-radius:8px;font-size:.85rem;">News</a></li>
                        <li><a class="dropdown-item" href="{{ route('notices') }}" style="border-radius:8px;font-size:.85rem;">Notices</a></li>
                        <li><a class="dropdown-item" href="{{ route('gallery') }}" style="border-radius:8px;font-size:.85rem;">Gallery</a></li>
                        <li><a class="dropdown-item" href="{{ route('facilities') }}" style="border-radius:8px;font-size:.85rem;">Facilities</a></li>
                    </ul>
                </div>
                <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
            </div>

            <!-- Right Side -->
            <div class="d-flex align-items-center gap-2">
                <!-- Dark Mode -->
                <button class="nav-action-btn theme-toggle border-0 bg-transparent" data-theme-toggle title="Toggle Dark Mode">
                    <i class="bi bi-moon"></i>
                </button>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn-primary-sc btn-sm-sc">Dashboard</a>
                    @elseif(auth()->user()->isFaculty())
                        <a href="{{ route('faculty.dashboard') }}" class="btn-primary-sc btn-sm-sc">Dashboard</a>
                    @else
                        <a href="{{ route('student.dashboard') }}" class="btn-primary-sc btn-sm-sc">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-outline-sc btn-sm-sc d-none d-sm-inline-flex">Login</a>
                    <a href="{{ route('register') }}" class="btn-primary-sc btn-sm-sc">Apply Now</a>
                @endauth
                <!-- Mobile Toggle -->
                <button class="d-xl-none btn border-0 p-0" id="mobileMenuToggle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;background:var(--bg);border-radius:8px;border:1px solid var(--border) !important;">
                    <i class="bi bi-list fs-5"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Nav Drawer -->
<div id="mobileNav" style="position:fixed;top:0;right:-100%;width:300px;height:100vh;background:var(--card);z-index:1050;transition:right .3s;overflow-y:auto;box-shadow:-4px 0 20px rgba(0,0,0,.15);padding:1.5rem;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <strong style="color:var(--primary);font-family:'Poppins',sans-serif;">SMART CAMPUS</strong>
        <button id="closeMobileNav" class="border-0 bg-transparent" style="font-size:1.3rem;color:var(--text-muted);">&times;</button>
    </div>
    <div style="border-top:1px solid var(--border);padding-top:1rem;">
        <a href="{{ route('home') }}" class="d-block py-2 px-2 rounded" style="color:var(--text);font-size:.9rem;font-weight:500;">Home</a>
        <a href="{{ route('about') }}" class="d-block py-2 px-2 rounded" style="color:var(--text);font-size:.9rem;">About College</a>
        <a href="{{ route('departments') }}" class="d-block py-2 px-2 rounded" style="color:var(--text);font-size:.9rem;">Departments</a>
        <a href="{{ route('courses') }}" class="d-block py-2 px-2 rounded" style="color:var(--text);font-size:.9rem;">Courses</a>
        <a href="{{ route('faculty') }}" class="d-block py-2 px-2 rounded" style="color:var(--text);font-size:.9rem;">Faculty</a>
        <a href="{{ route('admissions') }}" class="d-block py-2 px-2 rounded" style="color:var(--text);font-size:.9rem;">Admissions</a>
        <a href="{{ route('events') }}" class="d-block py-2 px-2 rounded" style="color:var(--text);font-size:.9rem;">Events</a>
        <a href="{{ route('notices') }}" class="d-block py-2 px-2 rounded" style="color:var(--text);font-size:.9rem;">Notices</a>
        <a href="{{ route('gallery') }}" class="d-block py-2 px-2 rounded" style="color:var(--text);font-size:.9rem;">Gallery</a>
        <a href="{{ route('placements') }}" class="d-block py-2 px-2 rounded" style="color:var(--text);font-size:.9rem;">Placements</a>
        <a href="{{ route('scholarships') }}" class="d-block py-2 px-2 rounded" style="color:var(--text);font-size:.9rem;">Scholarships</a>
        <a href="{{ route('contact') }}" class="d-block py-2 px-2 rounded" style="color:var(--text);font-size:.9rem;">Contact</a>
        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('login') }}" class="btn-outline-sc btn-sm-sc flex-1 text-center" style="flex:1;">Login</a>
            <a href="{{ route('register') }}" class="btn-primary-sc btn-sm-sc flex-1 text-center" style="flex:1;">Apply</a>
        </div>
    </div>
</div>
<div id="mobileOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1049;"></div>

@yield('content')

<!-- Footer -->
<footer class="sc-footer">
    <div class="container-xl">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="footer-brand d-flex align-items-center gap-2 mb-3">
                    <div class="sidebar-logo">S</div>
                    <span>SMART CAMPUS</span>
                </div>
                <p class="footer-desc">SMART CAMPUS College of Technology is a premier institution dedicated to academic excellence, innovation, and holistic development of students.</p>
                <div class="social-links mt-3">
                    <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            <div class="col-sm-6 col-lg-2">
                <h5>Academics</h5>
                <a href="{{ route('departments') }}">Departments</a>
                <a href="{{ route('courses') }}">Courses</a>
                <a href="{{ route('faculty') }}">Faculty</a>
                <a href="{{ route('library') }}">Library</a>
            </div>
            <div class="col-sm-6 col-lg-2">
                <h5>Campus Life</h5>
                <a href="{{ route('events') }}">Events</a>
                <a href="{{ route('news') }}">News</a>
                <a href="{{ route('gallery') }}">Gallery</a>
                <a href="{{ route('facilities') }}">Facilities</a>
            </div>
            <div class="col-sm-6 col-lg-2">
                <h5>Admissions</h5>
                <a href="{{ route('admissions') }}">Apply Now</a>
                <a href="{{ route('scholarships') }}">Scholarships</a>
                <a href="{{ route('placements') }}">Placements</a>
                <a href="{{ route('contact') }}">Contact Us</a>
            </div>
            <div class="col-sm-6 col-lg-2">
                <h5>Quick Links</h5>
                <a href="{{ route('login') }}">Student Login</a>
                <a href="{{ route('login') }}">Faculty Login</a>
                <a href="{{ route('notices') }}">Notices</a>
                <a href="{{ route('about') }}">About Us</a>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <p class="footer-bottom mb-0">© {{ date('Y') }} SMART CAMPUS College of Technology. All rights reserved.</p>
            <div class="d-flex gap-3">
                <a href="#" class="footer-bottom" style="color:rgba(255,255,255,.45) !important;">Privacy Policy</a>
                <a href="#" class="footer-bottom" style="color:rgba(255,255,255,.45) !important;">Terms of Use</a>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.4/gsap.min.js"></script>
<script src="{{ secure_asset('js/smartcampus.js') }}"></script>
<script>
    // Mobile nav
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileNav = document.getElementById('mobileNav');
    const mobileOverlay = document.getElementById('mobileOverlay');
    const closeMobileNav = document.getElementById('closeMobileNav');
    function openMobileNav() { mobileNav.style.right = '0'; mobileOverlay.style.display = 'block'; }
    function closeMobileNavFn() { mobileNav.style.right = '-100%'; mobileOverlay.style.display = 'none'; }
    if (mobileMenuToggle) mobileMenuToggle.addEventListener('click', openMobileNav);
    if (closeMobileNav) closeMobileNav.addEventListener('click', closeMobileNavFn);
    if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileNavFn);
</script>
@stack('scripts')
</body>
</html>
