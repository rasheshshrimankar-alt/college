<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Dashboard') | SMART CAMPUS</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ secure_asset('css/smartcampus.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.4/gsap.min.js"></script>
@stack('styles')
<style>
.sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:998;backdrop-filter:blur(2px);}
@keyframes fadeInLeft{from{opacity:0;transform:translateX(-20px)}to{opacity:1;transform:translateX(0)}}
@keyframes fadeInDown{from{opacity:0;transform:translateY(-15px)}to{opacity:1;transform:translateY(0)}}
@keyframes scaleIn{from{opacity:0;transform:scale(.95)}to{opacity:1;transform:scale(1)}}
@keyframes slideUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
@keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
.animate-fade-left{animation:fadeInLeft .5s ease both}
.animate-fade-down{animation:fadeInDown .4s ease both}
.animate-scale-in{animation:scaleIn .4s ease both}
.animate-slide-up{animation:slideUp .5s ease both}
.anim-delay-1{animation-delay:.1s}
.anim-delay-2{animation-delay:.2s}
.anim-delay-3{animation-delay:.3s}
.anim-delay-4{animation-delay:.4s}
.anim-delay-5{animation-delay:.5s}
.anim-delay-6{animation-delay:.6s}
/* Notification Dropdown */
.notif-dropdown{position:absolute;top:calc(100% + 10px);right:0;width:340px;background:var(--card);border:1px solid var(--border);border-radius:14px;box-shadow:var(--shadow-lg);z-index:200;display:none;animation:scaleIn .2s ease}
.notif-dropdown.show{display:block}
[data-theme="dark"] .notif-dropdown{background:var(--card-dark);border-color:var(--border-dark)}
/* Table actions */
.table-action-btn{width:30px;height:30px;border-radius:7px;border:none;display:inline-flex;align-items:center;justify-content:center;font-size:.78rem;cursor:pointer;transition:all .2s}
.table-action-btn.view{background:rgba(49,87,213,.1);color:var(--primary)}
.table-action-btn.edit{background:rgba(245,158,11,.1);color:var(--warning)}
.table-action-btn.delete{background:rgba(239,68,68,.1);color:var(--danger)}
.table-action-btn:hover{transform:scale(1.1)}
/* Search bar */
.sc-search-wrapper{position:relative}
.sc-search-wrapper .sc-input{padding-left:2.5rem}
.sc-search-wrapper i{position:absolute;left:.85rem;top:50%;transform:translateY(-50%);color:var(--text-muted)}
</style>
</head>
<body>
<div class="page-loader" id="pageLoader">
    <div class="text-center">
        <div class="sc-spinner mx-auto mb-2"></div>
        <div style="font-size:.75rem;color:var(--text-muted);font-weight:600;letter-spacing:1px">SMART CAMPUS</div>
    </div>
</div>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<div class="dashboard-wrapper">
    <!-- SIDEBAR -->
    <aside class="sc-sidebar" id="scSidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <div class="sidebar-logo">S</div>
                <div class="sidebar-title">SMART<span>CAMPUS</span></div>
            </div>
        </div>
        <div class="sidebar-user">
            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="sidebar-avatar">
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ Str::limit(auth()->user()->name, 20) }}</div>
                <div class="sidebar-user-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>
        <nav class="sidebar-nav">
            @yield('sidebar')
        </nav>
        <div style="padding:.75rem;border-top:1px solid rgba(255,255,255,.08);flex-shrink:0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-item w-100 border-0" style="background:rgba(239,68,68,.1);color:#FC8181">
                    <i class="bi bi-box-arrow-left"></i>
                    <span class="item-text">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="dashboard-main" id="dashboardMain">
        <!-- TOP NAVBAR -->
        <header class="dashboard-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" id="sidebarToggleBtn" title="Toggle Sidebar">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div class="d-none d-md-block">
                    <div style="font-size:.82rem;font-weight:600;color:var(--text)">@yield('page_title','Dashboard')</div>
                    <div class="page-breadcrumb">
                        <a href="#">Home</a>
                        <i class="bi bi-chevron-right"></i>
                        @yield('breadcrumb')
                    </div>
                </div>
            </div>
            <div class="dashboard-nav-right">
                <!-- Search -->
                <div class="d-none d-lg-block" style="position:relative">
                    <input type="text" placeholder="Search..." style="width:220px;padding:.4rem .9rem .4rem 2.2rem;border:1.5px solid var(--border);border-radius:9px;font-size:.82rem;background:var(--bg);color:var(--text);outline:none;transition:all .3s" onfocus="this.style.borderColor='var(--primary)';this.style.width='260px'" onblur="this.style.borderColor='var(--border)';this.style.width='220px'">
                    <i class="bi bi-search" style="position:absolute;left:.7rem;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:.8rem"></i>
                </div>
                <!-- Dark Mode -->
                <button class="nav-action-btn border-0" data-theme-toggle title="Toggle Theme" style="background:var(--bg)">
                    <i class="bi bi-moon"></i>
                </button>
                <!-- Notifications -->
                <div style="position:relative">
                    <button class="nav-action-btn border-0 notification-bell" id="notifBell" style="background:var(--bg)">
                        <i class="bi bi-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <div class="notif-dropdown" id="notifDropdown">
                        <div style="padding:.875rem 1rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center">
                            <strong style="font-size:.875rem">Notifications</strong>
                            <span class="sc-badge badge-primary">3 New</span>
                        </div>
                        <div style="max-height:300px;overflow-y:auto">
                            <div class="notification-item unread">
                                <div class="notification-icon" style="background:rgba(49,87,213,.1);color:var(--primary)"><i class="bi bi-info-circle"></i></div>
                                <div class="notification-text flex-1">
                                    <h6>New Admission Application</h6>
                                    <p>A new admission request has been received.</p>
                                </div>
                                <small class="notification-time">2m ago</small>
                            </div>
                            <div class="notification-item unread">
                                <div class="notification-icon" style="background:rgba(34,197,94,.1);color:var(--success)"><i class="bi bi-cash"></i></div>
                                <div class="notification-text flex-1">
                                    <h6>Fee Payment Received</h6>
                                    <p>₹45,000 fee payment confirmed.</p>
                                </div>
                                <small class="notification-time">1h ago</small>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon" style="background:rgba(245,158,11,.1);color:var(--warning)"><i class="bi bi-exclamation-triangle"></i></div>
                                <div class="notification-text flex-1">
                                    <h6>Exam Schedule Updated</h6>
                                    <p>Mid-semester exam dates have been revised.</p>
                                </div>
                                <small class="notification-time">3h ago</small>
                            </div>
                        </div>
                        <div style="padding:.75rem 1rem;text-align:center;border-top:1px solid var(--border)">
                            <a href="#" style="font-size:.8rem;color:var(--primary);font-weight:600">View All Notifications</a>
                        </div>
                    </div>
                </div>
                <!-- User Dropdown -->
                <div class="dropdown">
                    <div class="nav-user-btn dropdown-toggle" data-bs-toggle="dropdown" style="cursor:pointer">
                        <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="nav-avatar">
                        <span class="nav-user-name d-none d-md-block">{{ Str::limit(auth()->user()->name,15) }}</span>
                        <i class="bi bi-chevron-down" style="font-size:.65rem;color:var(--text-muted)"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius:12px;min-width:200px;padding:.5rem">
                        <li><h6 class="dropdown-header" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.5px">{{ ucfirst(auth()->user()->role) }}</h6></li>
                        <li><a class="dropdown-item" href="#" style="border-radius:8px;font-size:.85rem"><i class="bi bi-person me-2"></i>My Profile</a></li>
                        <li><a class="dropdown-item" href="#" style="border-radius:8px;font-size:.85rem"><i class="bi bi-gear me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit" style="border-radius:8px;font-size:.85rem"><i class="bi bi-box-arrow-left me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="dashboard-content">
            @if(session('success'))
            <div class="sc-alert success animate-fade-down" data-auto-dismiss="4000">
                <i class="bi bi-check-circle-fill"></i>
                <div>{{ session('success') }}</div>
            </div>
            @endif
            @if(session('error'))
            <div class="sc-alert danger animate-fade-down" data-auto-dismiss="4000">
                <i class="bi bi-x-circle-fill"></i>
                <div>{{ session('error') }}</div>
            </div>
            @endif
            @if($errors->any())
            <div class="sc-alert danger animate-fade-down">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
            </div>
            @endif
            @yield('content')
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ secure_asset('js/smartcampus.js') }}"></script>
<script>
// Sidebar toggle
const sidebar = document.getElementById('scSidebar');
const main = document.getElementById('dashboardMain');
const overlay = document.getElementById('sidebarOverlay');
const toggleBtn = document.getElementById('sidebarToggleBtn');
function toggleSidebar(){
    if(window.innerWidth<=991){
        sidebar.classList.toggle('mobile-open');
        overlay.style.display = sidebar.classList.contains('mobile-open')?'block':'none';
    } else {
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('expanded');
        localStorage.setItem('sc-sidebar', sidebar.classList.contains('collapsed')?'collapsed':'open');
    }
}
if(toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
if(overlay) overlay.addEventListener('click', ()=>{ sidebar.classList.remove('mobile-open'); overlay.style.display='none'; });
// Restore sidebar state
if(window.innerWidth>991 && localStorage.getItem('sc-sidebar')==='collapsed'){ sidebar.classList.add('collapsed'); main.classList.add('expanded'); }
// Notifications dropdown
const bell = document.getElementById('notifBell');
const notifDrop = document.getElementById('notifDropdown');
if(bell) bell.addEventListener('click', e=>{ e.stopPropagation(); notifDrop.classList.toggle('show'); });
document.addEventListener('click', ()=>{ if(notifDrop) notifDrop.classList.remove('show'); });
// Animate sidebar items
document.querySelectorAll('.sidebar-item').forEach((el,i)=>{
    el.style.animation = `fadeInLeft .4s ease ${i*0.03}s both`;
});
// Animate stat cards
document.querySelectorAll('.sc-card').forEach((el,i)=>{
    el.style.animation = `slideUp .5s ease ${i*0.08}s both`;
});
</script>
@stack('scripts')
</body>
</html>
