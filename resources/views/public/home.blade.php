@extends('layouts.public')
@section('title','Home')
@section('meta_description','SMART CAMPUS College of Technology - Premier education with modern facilities, expert faculty, and excellent placement record.')

@section('content')

{{-- ═══ HERO ═══ --}}
<section class="hero-section" style="padding-top:7rem">
    <div class="hero-bg-shapes">
        <div class="shape" style="width:600px;height:600px;top:-200px;right:-150px;background:rgba(49,87,213,.06);border-radius:50%"></div>
        <div class="shape" style="width:400px;height:400px;bottom:-100px;left:-100px;background:rgba(120,86,216,.06);border-radius:50%"></div>
    </div>
    <div class="container-xl">
        <div class="row align-items-center min-vh-85">
            <div class="col-lg-6">
                <div class="hero-badge animate-fade-down">
                    <i class="bi bi-stars me-1" style="color:#F59E0B"></i>
                    India's Premier Engineering College
                </div>
                <h1 class="hero-title animate-fade-down" style="animation-delay:.15s">
                    Shape Your Future at <span class="gradient-text">SMART CAMPUS</span>
                </h1>
                <p class="hero-desc animate-fade-down" style="animation-delay:.3s">
                    World-class education, cutting-edge research, and industry-leading placements. 
                    Join thousands of students who transformed their careers with us.
                </p>
                <div class="hero-cta d-flex flex-wrap gap-3 animate-fade-down" style="animation-delay:.45s">
                    <a href="{{ route('admissions') }}" class="btn-primary-sc" style="padding:.875rem 2rem;font-size:1rem">
                        <i class="bi bi-mortarboard me-2"></i>Apply Now
                    </a>
                    <a href="{{ route('courses') }}" class="btn-outline-sc" style="padding:.875rem 2rem;font-size:1rem">
                        <i class="bi bi-book me-2"></i>Explore Courses
                    </a>
                </div>
                {{-- Stats --}}
                <div class="hero-stats row g-3 mt-4 animate-fade-down" style="animation-delay:.6s">
                    <div class="col-3 text-center">
                        <div style="font-size:1.8rem;font-weight:900;background:var(--gradient-1);-webkit-background-clip:text;-webkit-text-fill-color:transparent">{{ number_format($stats['students']) }}+</div>
                        <div style="font-size:.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px">Students</div>
                    </div>
                    <div class="col-3 text-center">
                        <div style="font-size:1.8rem;font-weight:900;background:var(--gradient-1);-webkit-background-clip:text;-webkit-text-fill-color:transparent">{{ $stats['faculty'] }}+</div>
                        <div style="font-size:.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px">Faculty</div>
                    </div>
                    <div class="col-3 text-center">
                        <div style="font-size:1.8rem;font-weight:900;background:var(--gradient-1);-webkit-background-clip:text;-webkit-text-fill-color:transparent">{{ $stats['placements'] }}+</div>
                        <div style="font-size:.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px">Placements</div>
                    </div>
                    <div class="col-3 text-center">
                        <div style="font-size:1.8rem;font-weight:900;background:var(--gradient-1);-webkit-background-clip:text;-webkit-text-fill-color:transparent">₹{{ number_format($stats['avg_package'],1) }}</div>
                        <div style="font-size:.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px">Avg LPA</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block animate-fade-down" style="animation-delay:.3s">
                <div style="position:relative;padding:2rem">
                    {{-- Main visual card --}}
                    <div style="background:var(--gradient-1);border-radius:24px;padding:2.5rem;color:white;position:relative;overflow:hidden">
                        <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;background:rgba(255,255,255,.08);border-radius:50%"></div>
                        <div style="position:absolute;bottom:-30px;left:-20px;width:150px;height:150px;background:rgba(255,255,255,.06);border-radius:50%"></div>
                        <div style="position:relative">
                            <div style="font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;opacity:.75;margin-bottom:1rem">Academic Dashboard</div>
                            <div class="row g-2 mb-3">
                                @foreach([['Attendance','94%','bi-calendar-check','rgba(34,197,94,.2)','#22C55E'],['GPA','3.8/4.0','bi-award','rgba(245,158,11,.2)','#F59E0B'],['Courses','6 Active','bi-book','rgba(255,255,255,.15)','white'],['Rank','#12/250','bi-trophy','rgba(120,86,216,.3)','#C4B5FD']] as [$label,$val,$icon,$bg,$color])
                                <div class="col-6"><div style="background:{{ $bg }};border-radius:14px;padding:.875rem;display:flex;align-items:center;gap:.75rem"><i class="bi {{ $icon }}" style="font-size:1.3rem;color:{{ $color }}"></i><div><div style="font-size:1rem;font-weight:800;color:white">{{ $val }}</div><div style="font-size:.68rem;opacity:.7">{{ $label }}</div></div></div></div>
                                @endforeach
                            </div>
                            <div style="background:rgba(255,255,255,.1);border-radius:12px;padding:.875rem">
                                <div style="font-size:.75rem;opacity:.7;margin-bottom:.5rem">Recent Notices</div>
                                @foreach($notices->take(2) as $n)
                                <div style="font-size:.8rem;font-weight:600;padding:.3rem 0;border-bottom:1px solid rgba(255,255,255,.1)">{{ Str::limit($n->title,42) }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- Floating chips --}}
                    <div class="hero-floating-card" style="position:absolute;top:-10px;right:0;background:white;border-radius:14px;padding:.75rem 1rem;box-shadow:0 10px 30px rgba(0,0,0,.12);display:flex;align-items:center;gap:.75rem">
                        <div style="width:40px;height:40px;background:rgba(34,197,94,.12);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#22C55E;font-size:1.1rem"><i class="bi bi-graph-up-arrow"></i></div>
                        <div><div style="font-weight:700;font-size:.85rem;color:#1E293B">95% Placement</div><div style="font-size:.7rem;color:#94A3B8">Rate 2024</div></div>
                    </div>
                    <div class="hero-floating-card" style="position:absolute;bottom:5px;left:0;background:white;border-radius:14px;padding:.75rem 1rem;box-shadow:0 10px 30px rgba(0,0,0,.12);display:flex;align-items:center;gap:.75rem">
                        <div style="width:40px;height:40px;background:rgba(49,87,213,.12);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#3157D5;font-size:1.1rem"><i class="bi bi-buildings"></i></div>
                        <div><div style="font-weight:700;font-size:.85rem;color:#1E293B">{{ $stats['departments'] }} Departments</div><div style="font-size:.7rem;color:#94A3B8">{{ $stats['courses'] }} Courses</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ═══ CAMPUS INTRO GALLERY ═══ --}}
<section class="campus-showcase section-padding" aria-labelledby="campus-showcase-title">
    <div class="container-xl">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label">Discover SMART CAMPUS</div>
            <h2 class="section-title" id="campus-showcase-title">A Place to <span class="gradient-text">Learn, Create & Grow</span></h2>
            <p class="section-desc">Explore the spaces, people and experiences that make campus life inspiring.</p>
        </div>
        <div class="campus-gallery-grid">
            <figure class="campus-photo campus-photo-featured" data-aos="fade-up">
                <img src="https://images.unsplash.com/photo-1562774053-701939374585?auto=format&amp;fit=crop&amp;w=1200&amp;q=85" alt="Modern university campus building surrounded by greenery" loading="lazy">
                <figcaption><span>Our Campus</span><strong>A welcoming place to belong</strong></figcaption>
            </figure>
            <figure class="campus-photo" data-aos="fade-up" data-aos-delay="100">
                <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&amp;fit=crop&amp;w=900&amp;q=85" alt="Students celebrating their college graduation" loading="lazy">
                <figcaption><span>Student Success</span><strong>Celebrate every achievement</strong></figcaption>
            </figure>
            <figure class="campus-photo" data-aos="fade-up" data-aos-delay="180">
                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&amp;fit=crop&amp;w=900&amp;q=85" alt="Bright collaborative classroom with students learning" loading="lazy">
                <figcaption><span>Learning Spaces</span><strong>Ideas grow together</strong></figcaption>
            </figure>
            <figure class="campus-photo" data-aos="fade-up" data-aos-delay="260">
                <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&amp;fit=crop&amp;w=900&amp;q=85" alt="Students studying together in a campus learning space" loading="lazy">
                <figcaption><span>Campus Community</span><strong>Learn with one another</strong></figcaption>
            </figure>
        </div>
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="{{ route('gallery') }}" class="btn-outline-sc">Explore Campus Gallery <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
    </div>
</section>

{{-- ═══ MARQUEE COMPANIES ═══ --}}
<div style="background:var(--bg-dark,#0F172A);padding:1.2rem 0;overflow:hidden;position:relative">
    <div style="display:flex;gap:3rem;animation:marquee 25s linear infinite;white-space:nowrap;width:max-content">
        @foreach(['Google','Microsoft','Amazon','Infosys','TCS','Wipro','Accenture','IBM','Cognizant','HCL','Meta','Apple','Tesla','Adobe','Flipkart','Oracle'] as $company)
        <span style="color:rgba(255,255,255,.5);font-weight:700;font-size:.9rem;letter-spacing:.5px">{{ $company }}</span>
        @endforeach
        @foreach(['Google','Microsoft','Amazon','Infosys','TCS','Wipro','Accenture','IBM','Cognizant','HCL','Meta','Apple','Tesla','Adobe','Flipkart','Oracle'] as $company)
        <span style="color:rgba(255,255,255,.5);font-weight:700;font-size:.9rem;letter-spacing:.5px">{{ $company }}</span>
        @endforeach
    </div>
    <div style="position:absolute;left:0;top:0;bottom:0;width:80px;background:linear-gradient(to right,#0F172A,transparent)"></div>
    <div style="position:absolute;right:0;top:0;bottom:0;width:80px;background:linear-gradient(to left,#0F172A,transparent)"></div>
</div>

{{-- ═══ DEPARTMENTS ═══ --}}
<section class="section-padding">
    <div class="container-xl">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label">Academic Excellence</div>
            <h2 class="section-title">Our <span class="gradient-text">Departments</span></h2>
            <p class="section-desc">World-class programs across engineering, management, and sciences</p>
        </div>
        <div class="row g-3">
            @foreach($departments as $i => $dept)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $i*100 }}">
                <a href="{{ route('departments') }}" class="text-decoration-none">
                    <div class="sc-card dept-card h-100" style="transition:all .3s" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div class="dept-icon"><i class="bi bi-building-fill"></i></div>
                        <h4>{{ $dept->name }}</h4>
                        <div class="dept-badge mb-2">{{ $dept->code }}</div>
                        <p>{{ Str::limit($dept->description ?? 'Quality education with industry-relevant curriculum.',75) }}</p>
                        <div class="d-flex justify-content-around mt-3" style="border-top:1px solid var(--border);padding-top:1rem">
                            <div class="text-center"><div style="font-size:1.2rem;font-weight:800;color:var(--primary)">{{ $dept->courses_count }}</div><div style="font-size:.7rem;color:var(--text-muted)">Courses</div></div>
                            <div class="text-center"><div style="font-size:1.2rem;font-weight:800;color:var(--secondary)">{{ $dept->faculty_count }}</div><div style="font-size:.7rem;color:var(--text-muted)">Faculty</div></div>
                            <div class="text-center"><div style="font-size:1.2rem;font-weight:800;color:var(--success)">{{ $dept->students_count }}</div><div style="font-size:.7rem;color:var(--text-muted)">Students</div></div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4" data-aos="fade-up"><a href="{{ route('departments') }}" class="btn-primary-sc">View All Departments <i class="bi bi-arrow-right ms-1"></i></a></div>
    </div>
</section>

{{-- ═══ NOTICE TICKER ═══ --}}
@if($notices->count())
<div style="background:rgba(49,87,213,.06);border-top:1px solid rgba(49,87,213,.12);border-bottom:1px solid rgba(49,87,213,.12);padding:.75rem 0">
    <div class="container-xl">
        <div class="d-flex align-items-center gap-3">
            <span class="sc-badge badge-primary flex-shrink-0"><i class="bi bi-megaphone me-1"></i>NOTICE</span>
            <div style="overflow:hidden;white-space:nowrap;flex:1;position:relative">
                <div style="display:inline-block;animation:marquee 30s linear infinite">
                    @foreach($notices as $notice) <span style="margin-right:4rem;font-size:.85rem;font-weight:500;color:var(--text)">{{ $notice->title }}</span> @endforeach
                    @foreach($notices as $notice) <span style="margin-right:4rem;font-size:.85rem;font-weight:500;color:var(--text)">{{ $notice->title }}</span> @endforeach
                </div>
            </div>
            <a href="{{ route('notices') }}" class="btn-outline-sc btn-sm-sc flex-shrink-0" style="font-size:.75rem">View All</a>
        </div>
    </div>
</div>
@endif

{{-- ═══ COURSES ═══ --}}
<section class="section-padding" style="background:var(--bg)">
    <div class="container-xl">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label">Programs Offered</div>
            <h2 class="section-title">Popular <span class="gradient-text">Courses</span></h2>
        </div>
        <div class="row g-3">
            @foreach($courses as $i => $course)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $i*80 }}">
                <div class="sc-card h-100" style="padding:1.5rem;transition:all .3s;cursor:pointer" onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='var(--shadow-lg)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='var(--shadow)'">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div style="width:50px;height:50px;background:var(--gradient-1);border-radius:12px;display:flex;align-items:center;justify-content:center;color:white;font-size:1.3rem"><i class="bi bi-book-fill"></i></div>
                        <span class="sc-badge badge-secondary" style="font-size:.65rem">{{ $course->duration_years }} Year</span>
                    </div>
                    <h5 style="font-weight:700;font-size:.95rem;margin-bottom:.4rem">{{ $course->name }}</h5>
                    <div style="font-size:.78rem;color:var(--primary);font-weight:600;margin-bottom:.75rem">{{ $course->department->name ?? '' }}</div>
                    <div class="d-flex justify-content-between" style="font-size:.78rem;color:var(--text-muted);border-top:1px solid var(--border);padding-top:.75rem">
                        <span><i class="bi bi-people me-1"></i>{{ $course->total_seats }} seats</span>
                        <span><i class="bi bi-calendar me-1"></i>{{ $course->total_semesters }} semesters</span>
                        <span style="font-weight:700;color:var(--primary)">₹{{ number_format($course->fees_per_semester) }}/sem</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4" data-aos="fade-up"><a href="{{ route('courses') }}" class="btn-primary-sc">Explore All Courses <i class="bi bi-arrow-right ms-1"></i></a></div>
    </div>
</section>

{{-- ═══ EVENTS ═══ --}}
@if($events->count())
<section class="section-padding">
    <div class="container-xl">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label">Campus Life</div>
            <h2 class="section-title">Upcoming <span class="gradient-text">Events</span></h2>
        </div>
        <div class="row g-3">
            @foreach($events as $i => $event)
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $i*100 }}">
                <div class="sc-card event-card h-100" style="padding:1.25rem;transition:all .3s" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div class="event-date" style="margin-bottom:1rem">
                        <span style="display:block;font-size:2rem;font-weight:900;line-height:1;background:var(--gradient-1);-webkit-background-clip:text;-webkit-text-fill-color:transparent">{{ $event->start_datetime->format('d') }}</span>
                        <span style="font-size:.8rem;font-weight:700;color:var(--text-muted);text-transform:uppercase">{{ $event->start_datetime->format('M Y') }}</span>
                    </div>
                    <span class="sc-badge badge-primary mb-2" style="font-size:.65rem">{{ ucfirst($event->category) }}</span>
                    <h5 style="font-weight:700;font-size:.9rem;margin-bottom:.5rem">{{ $event->title }}</h5>
                    <div style="font-size:.78rem;color:var(--text-muted)"><i class="bi bi-geo-alt me-1"></i>{{ $event->venue }}</div>
                    <div style="font-size:.78rem;color:var(--text-muted);margin-top:.3rem"><i class="bi bi-clock me-1"></i>{{ $event->start_datetime->format('h:i A') }}</div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4" data-aos="fade-up"><a href="{{ route('events') }}" class="btn-outline-sc">View All Events <i class="bi bi-arrow-right ms-1"></i></a></div>
    </div>
</section>
@endif

{{-- ═══ FACULTY ═══ --}}
<section class="section-padding" style="background:var(--bg)">
    <div class="container-xl">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label">Expert Educators</div>
            <h2 class="section-title">Meet Our <span class="gradient-text">Faculty</span></h2>
        </div>
        <div class="row g-3">
            @foreach($faculty as $i => $f)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $i*80 }}">
                <div class="sc-card faculty-card text-center" style="padding:1.75rem;transition:all .3s" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
                    <img src="{{ $f->user->avatar_url }}" style="width:80px;height:80px;border-radius:50%;border:3px solid var(--primary-light);margin-bottom:1rem;object-fit:cover" alt="{{ $f->user->name }}">
                    <h5 style="font-weight:700;font-size:.95rem;margin-bottom:.25rem">{{ $f->user->name }}</h5>
                    <div style="color:var(--primary);font-size:.8rem;font-weight:600;margin-bottom:.25rem">{{ $f->designation }}</div>
                    <div style="color:var(--text-muted);font-size:.78rem;margin-bottom:.75rem">{{ $f->department->name ?? '' }}</div>
                    @if($f->qualification)<span class="sc-badge badge-secondary" style="font-size:.65rem">{{ $f->qualification }}</span>@endif
                    @if($f->experience)<div style="margin-top:.5rem;font-size:.75rem;color:var(--text-muted)"><i class="bi bi-clock me-1"></i>{{ $f->experience }}</div>@endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4" data-aos="fade-up"><a href="{{ route('faculty') }}" class="btn-primary-sc">Meet All Faculty <i class="bi bi-arrow-right ms-1"></i></a></div>
    </div>
</section>

{{-- ═══ PLACEMENTS BANNER ═══ --}}
<section style="background:var(--gradient-1);padding:5rem 0;position:relative;overflow:hidden">
    <div style="position:absolute;top:-100px;right:-100px;width:400px;height:400px;background:rgba(255,255,255,.05);border-radius:50%"></div>
    <div style="position:absolute;bottom:-80px;left:-60px;width:300px;height:300px;background:rgba(255,255,255,.05);border-radius:50%"></div>
    <div class="container-xl" style="position:relative">
        <div class="row align-items-center g-4">
            <div class="col-lg-6" data-aos="fade-right">
                <div style="font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.7);margin-bottom:.5rem">🏆 Placement Excellence</div>
                <h2 style="font-size:2.5rem;font-weight:800;color:white;line-height:1.2;margin-bottom:1rem">Career Success <br>Starts Here</h2>
                <p style="color:rgba(255,255,255,.8);font-size:.95rem;margin-bottom:2rem">Our students land jobs at top companies with competitive packages. 95% placement rate with average CTC of ₹{{ number_format($stats['avg_package'],1) }} LPA.</p>
                <a href="{{ route('placements') }}" style="background:white;color:var(--primary);padding:.875rem 2rem;border-radius:10px;text-decoration:none;font-weight:700;display:inline-flex;align-items:center;gap:.5rem;transition:all .3s" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 10px 30px rgba(0,0,0,.2)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'"><i class="bi bi-briefcase"></i> View Placements</a>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="row g-3">
                    @foreach([['₹'.number_format($stats['avg_package'],1).' LPA','Average Package','bi-graph-up-arrow'],[$stats['placements'].'+','Students Placed','bi-people-fill'],[$stats['placements'] > 0 ? '95%' : '90%','Placement Rate','bi-patch-check-fill'],['200+','Hiring Companies','bi-building']] as [$val,$label,$icon])
                    <div class="col-6">
                        <div style="background:rgba(255,255,255,.12);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.2);border-radius:16px;padding:1.5rem;text-align:center;transition:all .3s" onmouseover="this.style.background='rgba(255,255,255,.18)'" onmouseout="this.style.background='rgba(255,255,255,.12)'">
                            <i class="bi {{ $icon }}" style="font-size:2rem;color:rgba(255,255,255,.85);margin-bottom:.5rem;display:block"></i>
                            <div style="font-size:1.6rem;font-weight:900;color:white">{{ $val }}</div>
                            <div style="font-size:.78rem;color:rgba(255,255,255,.7)">{{ $label }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ NEWS ═══ --}}
@if($news->count())
<section class="section-padding">
    <div class="container-xl">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label">Stay Updated</div>
            <h2 class="section-title">Latest <span class="gradient-text">News</span></h2>
        </div>
        <div class="row g-3">
            @foreach($news as $i => $item)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $i*100 }}">
                <div class="sc-card h-100" style="padding:1.5rem;transition:all .3s" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <span class="sc-badge badge-primary mb-3" style="font-size:.65rem">{{ ucfirst($item->category ?? 'general') }}</span>
                    <h5 style="font-weight:700;font-size:.95rem;margin-bottom:.5rem;line-height:1.4">{{ Str::limit($item->title,70) }}</h5>
                    <p style="font-size:.82rem;color:var(--text-muted);margin-bottom:1rem">{{ Str::limit($item->excerpt ?? strip_tags($item->content),120) }}</p>
                    <div style="font-size:.75rem;color:var(--text-muted);border-top:1px solid var(--border);padding-top:.75rem"><i class="bi bi-clock me-1"></i>{{ $item->created_at->diffForHumans() }}</div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4" data-aos="fade-up"><a href="{{ route('news') }}" class="btn-outline-sc">Read More News <i class="bi bi-arrow-right ms-1"></i></a></div>
    </div>
</section>
@endif

{{-- ═══ CTA ═══ --}}
<section class="section-padding" style="background:var(--bg)">
    <div class="container-xl">
        <div data-aos="fade-up" style="background:var(--gradient-1);border-radius:24px;padding:4rem;text-align:center;position:relative;overflow:hidden">
            <div style="position:absolute;top:-80px;left:50%;transform:translateX(-50%);width:400px;height:400px;background:rgba(255,255,255,.05);border-radius:50%"></div>
            <div style="position:relative">
                <div style="font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.7);margin-bottom:.5rem">Begin Your Journey</div>
                <h2 style="font-size:2.5rem;font-weight:800;color:white;margin-bottom:1rem">Ready to Shape Your Future?</h2>
                <p style="color:rgba(255,255,255,.8);font-size:1rem;margin-bottom:2rem;max-width:500px;margin-left:auto;margin-right:auto">Join {{ number_format($stats['students']) }}+ students at SMART CAMPUS. Applications for {{ date('Y')+1 }} admissions are now open.</p>
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <a href="{{ route('admissions') }}" style="background:white;color:var(--primary);padding:.875rem 2.5rem;border-radius:10px;text-decoration:none;font-weight:800;font-size:1rem;display:inline-flex;align-items:center;gap:.5rem;transition:all .3s" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'"><i class="bi bi-mortarboard"></i> Apply Now — Free</a>
                    <a href="{{ route('contact') }}" style="background:rgba(255,255,255,.15);color:white;border:2px solid rgba(255,255,255,.4);padding:.875rem 2.5rem;border-radius:10px;text-decoration:none;font-weight:700;font-size:1rem;display:inline-flex;align-items:center;gap:.5rem;transition:all .3s" onmouseover="this.style.background='rgba(255,255,255,.25)'" onmouseout="this.style.background='rgba(255,255,255,.15)'"><i class="bi bi-chat"></i> Talk to Advisor</a>
                </div>
            </div>
        </div>
    </div>
</section>


@push('styles')
<style>
.campus-gallery-grid{display:grid;grid-template-columns:1.35fr 1fr 1fr;grid-template-rows:220px 220px;gap:1rem}
.campus-photo{position:relative;margin:0;overflow:hidden;border-radius:20px;min-height:200px;background:#dbeafe;box-shadow:0 12px 28px rgba(20,33,61,.10)}
.campus-photo-featured{grid-row:span 2}
.campus-photo img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .65s ease}
.campus-photo:hover img{transform:scale(1.06)}
.campus-photo:after{content:"";position:absolute;inset:35% 0 0;background:linear-gradient(transparent,rgba(9,22,38,.82))}
.campus-photo figcaption{position:absolute;z-index:1;left:1.25rem;right:1.25rem;bottom:1.15rem;color:#fff;display:flex;flex-direction:column;gap:.25rem}
.campus-photo figcaption span{font-size:.7rem;text-transform:uppercase;letter-spacing:1.3px;font-weight:800;color:#A7F3D0}
.campus-photo figcaption strong{font-size:1.05rem;line-height:1.25}
.campus-robot{position:fixed;z-index:90;right:22px;bottom:18px;width:148px;display:flex;flex-direction:column;align-items:center;pointer-events:none;filter:drop-shadow(0 10px 18px rgba(15,23,42,.14));animation:campusRobotFloat 3.4s ease-in-out infinite}
.campus-robot-bubble{background:#fff;color:#14213D;border:1px solid #CCFBF1;border-radius:15px;padding:.65rem .85rem;text-align:center;box-shadow:0 8px 25px rgba(20,33,61,.12);display:flex;flex-direction:column;gap:.15rem;margin-bottom:-2px;position:relative}
.campus-robot-bubble:after{content:"";position:absolute;left:calc(50% - 7px);bottom:-7px;width:12px;height:12px;background:#fff;border-right:1px solid #CCFBF1;border-bottom:1px solid #CCFBF1;transform:rotate(45deg)}
.campus-robot-bubble strong{font-size:.76rem}
.campus-robot-bubble span{font-size:.66rem;color:#64748B}
.campus-robot-art{width:128px;height:142px}
.campus-robot-art svg{width:100%;height:100%;overflow:visible}
.robot-wave{transform-box:fill-box;transform-origin:10% 90%;animation:campusRobotWave 1.5s ease-in-out infinite}
.robot-antenna{animation:campusRobotAntenna 1.8s ease-in-out infinite}
.robot-eye{animation:campusRobotBlink 4s infinite}
@keyframes campusRobotFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-9px)}}
@keyframes campusRobotWave{0%,100%{transform:rotate(0)}35%,70%{transform:rotate(-18deg)}}
@keyframes campusRobotAntenna{0%,100%{opacity:1}50%{opacity:.55}}
@keyframes campusRobotBlink{0%,45%,49%,100%{transform:scaleY(1)}47%{transform:scaleY(.12)}}
@media(max-width:767.98px){.campus-gallery-grid{grid-template-columns:1fr 1fr;grid-template-rows:210px 170px 170px}.campus-photo-featured{grid-column:span 2;grid-row:auto}.campus-robot{right:8px;bottom:8px;transform:scale(.82);transform-origin:bottom right}.campus-robot-art{width:112px;height:125px}}
@media(prefers-reduced-motion:reduce){.campus-robot,.robot-wave,.robot-antenna,.robot-eye,.campus-photo img{animation:none!important;transition:none!important}}
</style>
@endpush


{{-- Floating animated campus guide --}}
<div class="campus-robot" role="img" aria-label="Animated SMART CAMPUS robot guide">
    <div class="campus-robot-bubble"><strong>Hi, future achiever!</strong><span>Welcome to SMART CAMPUS</span></div>
    <div class="campus-robot-art" aria-hidden="true">
        <svg viewBox="0 0 140 156" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="70" cy="146" rx="37" ry="7" fill="#0f766e" opacity=".16"/>
            <path class="robot-antenna" d="M70 12V25" stroke="#E9B44C" stroke-width="5" stroke-linecap="round"/>
            <circle cx="70" cy="9" r="6" fill="#E9B44C"/>
            <rect x="35" y="25" width="70" height="56" rx="19" fill="#F8FAFC" stroke="#0F766E" stroke-width="4"/>
            <rect x="43" y="34" width="54" height="37" rx="13" fill="#14213D"/>
            <ellipse cx="57" cy="51" rx="4" ry="6" fill="#5EEAD4" class="robot-eye"/>
            <ellipse cx="83" cy="51" rx="4" ry="6" fill="#5EEAD4" class="robot-eye"/>
            <path d="M61 61Q70 68 79 61" fill="none" stroke="#F4D28B" stroke-width="3" stroke-linecap="round"/>
            <rect x="28" y="91" width="84" height="45" rx="15" fill="#0F766E"/>
            <rect x="49" y="101" width="42" height="24" rx="8" fill="#CCFBF1"/>
            <path d="M58 113h24" stroke="#0F766E" stroke-width="4" stroke-linecap="round"/>
            <path d="M35 99L22 111" stroke="#0F766E" stroke-width="10" stroke-linecap="round"/>
            <path class="robot-wave" d="M105 99L120 82" stroke="#0F766E" stroke-width="10" stroke-linecap="round"/>
            <path d="M52 135v7M88 135v7" stroke="#14213D" stroke-width="9" stroke-linecap="round"/>
            <path d="M43 145h18M79 145h18" stroke="#14213D" stroke-width="6" stroke-linecap="round"/>
            <circle cx="70" cy="113" r="3" fill="#E9B44C"/>
        </svg>
    </div>
</div>

@push('scripts')
<script>
// AOS-style scroll reveal
document.addEventListener('DOMContentLoaded',function(){
    const els=document.querySelectorAll('[data-aos]');
    const obs=new IntersectionObserver(entries=>{
        entries.forEach(e=>{
            if(e.isIntersecting){
                const delay=e.target.dataset.aosDelay||0;
                setTimeout(()=>e.target.classList.add('aos-animate'),parseInt(delay));
            }
        });
    },{threshold:.12,rootMargin:'0px 0px -50px 0px'});
    els.forEach(el=>{
        el.style.opacity='0';
        el.style.transform='translateY(30px)';
        el.style.transition='opacity .6s ease, transform .6s ease';
        obs.observe(el);
    });
});
document.querySelectorAll('.aos-animate').forEach(el=>{el.style.opacity='1';el.style.transform='translateY(0)'});
// Trigger immediately visible
setTimeout(()=>document.querySelectorAll('[data-aos]').forEach(el=>{
    const rect=el.getBoundingClientRect();
    if(rect.top<window.innerHeight){el.style.opacity='1';el.style.transform='translateY(0)';}
}),100);
</script>
@endpush
@endsection
