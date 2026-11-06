/**
 * SMART CAMPUS – Main JavaScript
 * Handles: Animations, Charts, Dark Mode, Sidebar, Counters, etc.
 */

'use strict';

// ═══════════════════════════════════════════════════════
// PAGE LOADER
// ═══════════════════════════════════════════════════════
window.addEventListener('load', () => {
    const loader = document.querySelector('.page-loader');
    if (loader) {
        setTimeout(() => loader.classList.add('hidden'), 400);
    }
});

// ═══════════════════════════════════════════════════════
// DARK MODE
// ═══════════════════════════════════════════════════════
const ThemeManager = {
    init() {
        const saved = localStorage.getItem('sc-theme') || 'light';
        document.documentElement.setAttribute('data-theme', saved);
        this.updateToggle(saved);
    },
    toggle() {
        const current = document.documentElement.getAttribute('data-theme');
        const next = current === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('sc-theme', next);
        this.updateToggle(next);
    },
    updateToggle(theme) {
        const toggles = document.querySelectorAll('.theme-toggle, [data-theme-toggle]');
        toggles.forEach(t => {
            const icon = t.querySelector('i');
            if (icon) {
                icon.className = theme === 'dark' ? 'bi bi-sun' : 'bi bi-moon';
            }
        });
    }
};
ThemeManager.init();
document.addEventListener('click', e => {
    if (e.target.closest('.theme-toggle, [data-theme-toggle]')) ThemeManager.toggle();
});

// ═══════════════════════════════════════════════════════
// SIDEBAR
// ═══════════════════════════════════════════════════════
const SidebarManager = {
    sidebar: null,
    main: null,
    overlay: null,
    init() {
        this.sidebar  = document.querySelector('.sc-sidebar');
        this.main     = document.querySelector('.dashboard-main');
        this.overlay  = document.querySelector('.sidebar-overlay');
        if (!this.sidebar) return;
        const saved = localStorage.getItem('sc-sidebar');
        if (saved === 'collapsed' && window.innerWidth > 991) this.collapse();
        // Toggle buttons
        document.querySelectorAll('.sidebar-toggle, [data-sidebar-toggle]').forEach(btn => {
            btn.addEventListener('click', () => this.toggle());
        });
        // Overlay close
        if (this.overlay) this.overlay.addEventListener('click', () => this.closeMobile());
        // Responsive
        window.addEventListener('resize', () => {
            if (window.innerWidth > 991) this.closeMobile();
        });
    },
    toggle() {
        if (window.innerWidth <= 991) {
            this.sidebar.classList.toggle('mobile-open');
            if (this.overlay) this.overlay.style.display = this.sidebar.classList.contains('mobile-open') ? 'block' : 'none';
        } else {
            this.sidebar.classList.toggle('collapsed');
            if (this.main) this.main.classList.toggle('expanded');
            localStorage.setItem('sc-sidebar', this.sidebar.classList.contains('collapsed') ? 'collapsed' : 'open');
        }
    },
    collapse() {
        this.sidebar.classList.add('collapsed');
        if (this.main) this.main.classList.add('expanded');
    },
    closeMobile() {
        this.sidebar.classList.remove('mobile-open');
        if (this.overlay) this.overlay.style.display = 'none';
    }
};

// ═══════════════════════════════════════════════════════
// NUMBER COUNTER ANIMATION
// ═══════════════════════════════════════════════════════
const CounterAnimation = {
    animateValue(el, start, end, duration) {
        const range = end - start;
        const startTime = performance.now();
        const isDecimal = String(end).includes('.');
        const decimals  = isDecimal ? 1 : 0;
        const step = (currentTime) => {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3); // ease-out cubic
            const current = start + range * eased;
            el.textContent = isDecimal
                ? current.toFixed(decimals)
                : Math.floor(current).toLocaleString();
            if (progress < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    },
    init() {
        const counters = document.querySelectorAll('[data-counter]');
        if (!counters.length) return;
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.dataset.counted) {
                    entry.target.dataset.counted = 'true';
                    const end = parseFloat(entry.target.dataset.counter);
                    const duration = parseInt(entry.target.dataset.duration || '1800');
                    this.animateValue(entry.target, 0, end, duration);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(c => observer.observe(c));
    }
};

// ═══════════════════════════════════════════════════════
// AOS – SCROLL REVEAL (Simple)
// ═══════════════════════════════════════════════════════
const ScrollReveal = {
    init() {
        const els = document.querySelectorAll('[data-aos]');
        if (!els.length) return;
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    const delay = entry.target.dataset.aosDelay || 0;
                    setTimeout(() => entry.target.classList.add('aos-animate'), parseInt(delay));
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
        els.forEach(el => observer.observe(el));
    }
};

// ═══════════════════════════════════════════════════════
// GSAP HERO ANIMATION
// ═══════════════════════════════════════════════════════
const HeroAnimation = {
    init() {
        if (typeof gsap === 'undefined') return;
        const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
        tl.from('.hero-badge',  { y: 30, opacity: 0, duration: .6, delay: .2 })
          .from('.hero-title',  { y: 40, opacity: 0, duration: .8 }, '-=.3')
          .from('.hero-desc',   { y: 30, opacity: 0, duration: .7 }, '-=.5')
          .from('.hero-cta',    { y: 20, opacity: 0, duration: .6 }, '-=.4')
          .from('.hero-stats',  { y: 20, opacity: 0, duration: .6 }, '-=.4')
          .from('.hero-floating-card', { scale: .8, opacity: 0, duration: .7, stagger: .2 }, '-=.3');
        // Floating shapes
        gsap.to('.hero-bg-shapes .shape', {
            y: -30, duration: 4, repeat: -1, yoyo: true, ease: 'sine.inOut', stagger: 1.5
        });
    }
};

// ═══════════════════════════════════════════════════════
// CHART.JS DASHBOARD CHARTS
// ═══════════════════════════════════════════════════════
const ChartManager = {
    defaults: {
        font: { family: "'Inter', system-ui, sans-serif", size: 12 },
        color: '#64748B'
    },
    init() {
        if (typeof Chart === 'undefined') return;
        Chart.defaults.font = this.defaults.font;
        Chart.defaults.color = this.defaults.color;
        this.initRevenueChart();
        this.initAdmissionChart();
        this.initAttendanceChart();
    },
    initRevenueChart() {
        const el = document.getElementById('revenueChart');
        if (!el) return;
        const data = JSON.parse(el.dataset.chartData || '[]');
        const labels = data.map(d => ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'][d.month - 1] || '');
        const values = data.map(d => d.total || 0);
        new Chart(el, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Revenue (₹)',
                    data: values,
                    backgroundColor: 'rgba(49,87,213,.85)',
                    borderRadius: 8,
                    borderSkipped: false,
                    hoverBackgroundColor: '#7856D8'
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, border: { display: false } },
                    y: { grid: { color: 'rgba(0,0,0,.05)' }, border: { display: false }, ticks: { callback: v => '₹' + (v/1000).toFixed(0) + 'K' } }
                }
            }
        });
    },
    initAdmissionChart() {
        const el = document.getElementById('admissionChart');
        if (!el) return;
        const data = JSON.parse(el.dataset.chartData || '{}');
        new Chart(el, {
            type: 'doughnut',
            data: {
                labels: ['Approved', 'Pending', 'Rejected', 'Waitlisted'],
                datasets: [{
                    data: [data.approved||0, data.pending||0, data.rejected||0, data.waitlisted||0],
                    backgroundColor: ['#22C55E','#3157D5','#EF4444','#F59E0B'],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false, cutout: '72%',
                plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, pointStyle: 'circle', padding: 16 } } }
            }
        });
    },
    initAttendanceChart() {
        const el = document.getElementById('attendanceChart');
        if (!el) return;
        const pct = parseFloat(el.dataset.percentage || 0);
        new Chart(el, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent'],
                datasets: [{ data: [pct, 100-pct], backgroundColor: ['#22C55E','#F1F5F9'], borderWidth: 0 }]
            },
            options: {
                responsive: true, maintainAspectRatio: false, cutout: '78%',
                plugins: { legend: { display: false }, tooltip: { callbacks: { label: ctx => ctx.label + ': ' + ctx.raw.toFixed(1) + '%' } } }
            }
        });
    }
};

// ═══════════════════════════════════════════════════════
// ALERTS – AUTO DISMISS
// ═══════════════════════════════════════════════════════
const AlertManager = {
    init() {
        document.querySelectorAll('.sc-alert[data-auto-dismiss]').forEach(alert => {
            const delay = parseInt(alert.dataset.autoDismiss || '4000');
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 300);
            }, delay);
        });
    }
};

// ═══════════════════════════════════════════════════════
// FORM VALIDATION ANIMATION
// ═══════════════════════════════════════════════════════
const FormValidation = {
    init() {
        document.querySelectorAll('form[data-validate]').forEach(form => {
            form.addEventListener('submit', e => {
                const inputs = form.querySelectorAll('[required]');
                let valid = true;
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        input.style.animation = 'shake .4s ease';
                        setTimeout(() => { input.style.animation = ''; }, 400);
                        valid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });
                if (!valid) e.preventDefault();
            });
        });
    }
};

// ═══════════════════════════════════════════════════════
// NOTIFICATION BELL
// ═══════════════════════════════════════════════════════
const NotificationManager = {
    init() {
        const bell = document.querySelector('.notification-bell');
        if (!bell) return;
        bell.addEventListener('click', (e) => {
            e.stopPropagation();
            const dropdown = document.querySelector('.notification-dropdown');
            if (dropdown) dropdown.classList.toggle('show');
        });
        document.addEventListener('click', () => {
            document.querySelectorAll('.notification-dropdown.show').forEach(d => d.classList.remove('show'));
        });
    }
};

// ═══════════════════════════════════════════════════════
// SMOOTH PROGRESS BARS
// ═══════════════════════════════════════════════════════
const ProgressAnimation = {
    init() {
        const bars = document.querySelectorAll('.sc-progress-bar[data-width]');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const bar = entry.target;
                    const width = bar.dataset.width;
                    setTimeout(() => { bar.style.width = width + '%'; }, 200);
                    observer.unobserve(bar);
                }
            });
        }, { threshold: 0.5 });
        bars.forEach(bar => { bar.style.width = '0%'; observer.observe(bar); });
    }
};

// ═══════════════════════════════════════════════════════
// NAVBAR SCROLL EFFECT
// ═══════════════════════════════════════════════════════
const NavbarScroll = {
    init() {
        const navbar = document.querySelector('.sc-navbar');
        if (!navbar) return;
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 4px 30px rgba(0,0,0,.1)';
            } else {
                navbar.style.boxShadow = '0 1px 20px rgba(0,0,0,.06)';
            }
        }, { passive: true });
    }
};

// ═══════════════════════════════════════════════════════
// GLOBAL CONFIRM DELETE
// ═══════════════════════════════════════════════════════
const ConfirmDelete = {
    init() {
        document.querySelectorAll('[data-confirm]').forEach(btn => {
            btn.addEventListener('click', e => {
                const msg = btn.dataset.confirm || 'Are you sure you want to delete this?';
                if (!confirm(msg)) e.preventDefault();
            });
        });
    }
};

// ═══════════════════════════════════════════════════════
// SEARCH WITH DEBOUNCE
// ═══════════════════════════════════════════════════════
const SearchDebounce = {
    init() {
        document.querySelectorAll('[data-search-form]').forEach(input => {
            let timeout;
            input.addEventListener('input', () => {
                clearTimeout(timeout);
                timeout = setTimeout(() => input.closest('form').submit(), 500);
            });
        });
    }
};

// ═══════════════════════════════════════════════════════
// TABLE ROW HOVER & SELECTION
// ═══════════════════════════════════════════════════════
const TableEnhancements = {
    init() {
        // Click table rows that have data-href
        document.querySelectorAll('tr[data-href]').forEach(row => {
            row.style.cursor = 'pointer';
            row.addEventListener('click', e => {
                if (!e.target.closest('a, button, input, select')) {
                    window.location.href = row.dataset.href;
                }
            });
        });
    }
};

// ═══════════════════════════════════════════════════════
// SHAKE ANIMATION (CSS injection)
// ═══════════════════════════════════════════════════════
const injectStyles = () => {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shake {
            0%,100%{transform:translateX(0)}
            20%{transform:translateX(-8px)}
            40%{transform:translateX(8px)}
            60%{transform:translateX(-5px)}
            80%{transform:translateX(5px)}
        }
        @keyframes slideInRight {
            from{transform:translateX(100%);opacity:0}
            to{transform:translateX(0);opacity:1}
        }
        @keyframes fadeInUp {
            from{transform:translateY(20px);opacity:0}
            to{transform:translateY(0);opacity:1}
        }
        .animate-slide-in { animation: slideInRight .4s ease; }
        .animate-fade-in-up { animation: fadeInUp .5s ease; }
        .dropdown-menu { animation: fadeInUp .2s ease; }
    `;
    document.head.appendChild(style);
};

// ═══════════════════════════════════════════════════════
// INITIALIZE ALL
// ═══════════════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', () => {
    injectStyles();
    SidebarManager.init();
    CounterAnimation.init();
    ScrollReveal.init();
    HeroAnimation.init();
    ChartManager.init();
    AlertManager.init();
    FormValidation.init();
    NotificationManager.init();
    ProgressAnimation.init();
    NavbarScroll.init();
    ConfirmDelete.init();
    SearchDebounce.init();
    TableEnhancements.init();

    // Bootstrap tooltips
    const tooltipEls = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    if (typeof bootstrap !== 'undefined' && tooltipEls.length) {
        tooltipEls.forEach(el => new bootstrap.Tooltip(el));
    }
});
