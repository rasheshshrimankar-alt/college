@extends('layouts.dashboard')
@section('title','Student Dashboard')
@section('page_title','My Dashboard')
@section('breadcrumb')<span>Dashboard</span>@endsection

@section('sidebar')@include('student.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div>
        <h1 class="page-title">Hello, {{ Str::limit(auth()->user()->name,20) }}! ðŸŽ“</h1>
        <p style="color:var(--text-muted);font-size:.875rem;margin:0">{{ now()->format('l, d F Y') }} â€” {{ $student->course->name ?? 'Student' }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('student.complaints.create') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-chat-left-plus"></i> Raise Complaint</a>
    </div>
</div>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-1">
        <div class="sc-card stat-card">
            <div class="stat-icon {{ $attendancePercent >= 75 ? 'green' : 'red' }}"><i class="bi bi-calendar-check-fill"></i></div>
            <div class="stat-info">
                <span class="stat-num" data-counter="{{ $attendancePercent }}">0</span>
                <span class="stat-label">Attendance %</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-2">
        <div class="sc-card stat-card">
            <div class="stat-icon purple"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="stat-info">
                <span class="stat-num" data-counter="{{ $avgPercentage }}">0</span>
                <span class="stat-label">Avg Score %</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-3">
        <div class="sc-card stat-card">
            <div class="stat-icon {{ $student->fees_due > 0 ? 'red' : 'green' }}"><i class="bi bi-cash-coin"></i></div>
            <div class="stat-info">
                <span class="stat-num" style="font-size:1.3rem">{{ $student->fees_due > 0 ? 'â‚¹'.number_format($student->fees_due) : 'Clear' }}</span>
                <span class="stat-label">Fees Due</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 animate-slide-up anim-delay-4">
        <div class="sc-card stat-card">
            <div class="stat-icon blue"><i class="bi bi-bookmark-check-fill"></i></div>
            <div class="stat-info">
                <span class="stat-num" data-counter="{{ $pendingAssignments }}">0</span>
                <span class="stat-label">Pending Tasks</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Student Info Card -->
    <div class="col-lg-4 animate-slide-up anim-delay-1">
        <div class="dashboard-card h-100">
            <div class="card-header-sc"><h5><i class="bi bi-person me-2 text-primary-sc"></i>My Info</h5><a href="{{ route('student.profile') }}" class="sc-badge badge-primary">Edit</a></div>
            <div class="card-body-sc text-center">
                <img src="{{ auth()->user()->avatar_url }}" style="width:80px;height:80px;border-radius:50%;border:4px solid var(--primary-light);margin-bottom:1rem" alt="">
                <h5 style="font-weight:800;font-size:1rem">{{ auth()->user()->name }}</h5>
                <div style="font-size:.82rem;color:var(--primary);font-weight:600;margin-bottom:.25rem">{{ $student->course->name ?? '-' }}</div>
                <div class="d-flex justify-content-around mt-3" style="border-top:1px solid var(--border);padding-top:1rem">
                    <div class="text-center"><div style="font-weight:800;font-size:.95rem;color:var(--text)">{{ $student->student_id }}</div><div style="font-size:.7rem;color:var(--text-muted)">Student ID</div></div>
                    <div class="text-center"><div style="font-weight:800;font-size:.95rem;color:var(--text)">Sem {{ $student->current_semester ?? 1 }}</div><div style="font-size:.7rem;color:var(--text-muted)">Current</div></div>
                    <div class="text-center"><div style="font-weight:800;font-size:.95rem;color:var(--text)">{{ $student->batch_year }}</div><div style="font-size:.7rem;color:var(--text-muted)">Batch</div></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Chart -->
    <div class="col-lg-4 animate-slide-up anim-delay-2">
        <div class="dashboard-card h-100">
            <div class="card-header-sc"><h5><i class="bi bi-pie-chart me-2 text-primary-sc"></i>Attendance</h5><a href="{{ route('student.attendance') }}" class="sc-badge badge-primary">View</a></div>
            <div class="card-body-sc text-center">
                <div style="position:relative;height:160px"><canvas id="attendanceChart" data-percentage="{{ $attendancePercent }}"></canvas></div>
                <div style="margin-top:.75rem">
                    @if($attendancePercent >= 75)
                    <div class="sc-badge badge-success" style="font-size:.8rem;padding:.4rem .9rem"><i class="bi bi-check-circle me-1"></i>{{ $attendancePercent }}% â€” Good Standing</div>
                    @else
                    <div class="sc-badge badge-danger" style="font-size:.8rem;padding:.4rem .9rem"><i class="bi bi-exclamation-triangle me-1"></i>{{ $attendancePercent }}% â€” Below 75%</div>
                    @endif
                </div>
                <div class="mt-2" style="font-size:.78rem;color:var(--text-muted)">{{ $totalPresent ?? 0 }} Present / {{ $totalClasses ?? 0 }} Total Classes</div>
            </div>
        </div>
    </div>

    <!-- Upcoming Exams -->
    <div class="col-lg-4 animate-slide-up anim-delay-3">
        <div class="dashboard-card h-100">
            <div class="card-header-sc"><h5><i class="bi bi-clipboard2-check me-2 text-primary-sc"></i>Upcoming Exams</h5></div>
            <div class="card-body-sc">
                @forelse($upcomingExams as $exam)
                <div class="d-flex gap-3 mb-3 pb-3" style="border-bottom:1px solid var(--border)">
                    <div style="min-width:44px;height:52px;background:var(--gradient-1);border-radius:10px;display:flex;flex-direction:column;align-items:center;justify-content:center;color:white;font-weight:700">
                        <span style="font-size:.55rem;text-transform:uppercase">{{ \Carbon\Carbon::parse($exam->start_date)->format('M') }}</span>
                        <span style="font-size:1rem">{{ \Carbon\Carbon::parse($exam->start_date)->format('d') }}</span>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:.85rem">{{ Str::limit($exam->name,30) }}</div>
                        <div style="font-size:.75rem;color:var(--text-muted)">{{ ucfirst($exam->type) }}</div>
                        <span class="sc-badge badge-warning" style="font-size:.62rem">{{ ucfirst($exam->status) }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-3" style="color:var(--text-muted);font-size:.85rem"><i class="bi bi-check-circle me-1 text-success"></i>No upcoming exams</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Recent Results -->
    <div class="col-lg-6 animate-slide-up anim-delay-1">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-graph-up me-2 text-primary-sc"></i>Recent Results</h5><a href="{{ route('student.results') }}" class="sc-badge badge-primary">View All</a></div>
            <div class="sc-table-wrapper"><table class="sc-table"><thead><tr><th>Subject</th><th>Marks</th><th>%</th><th>Grade</th></tr></thead><tbody>
            @forelse($recentResults as $r)
            <tr><td style="font-size:.85rem;font-weight:500">{{ Str::limit($r->subject->name ?? '-',28) }}</td><td>{{ $r->marks_obtained }}/{{ $r->total_marks }}</td><td style="font-weight:700;color:{{ $r->percentage>=75?'var(--success)':($r->percentage>=40?'var(--warning)':'var(--danger)') }}">{{ number_format($r->percentage,1) }}%</td><td><span class="sc-badge {{ $r->status=='pass'?'badge-success':'badge-danger' }}">{{ $r->grade ?? ($r->status=='pass'?'P':'F') }}</span></td></tr>
            @empty<tr><td colspan="4" class="text-center py-3" style="color:var(--text-muted)">No results yet</td></tr>@endforelse
            </tbody></table></div>
        </div>
    </div>

    <!-- Recent Notices -->
    <div class="col-lg-6 animate-slide-up anim-delay-2">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-megaphone me-2 text-primary-sc"></i>Recent Notices</h5><a href="{{ route('student.notices') }}" class="sc-badge badge-primary">View All</a></div>
            <div class="card-body-sc">
                @forelse($recentNotices as $notice)
                <div class="d-flex gap-3 mb-3 pb-3" style="border-bottom:1px solid var(--border)">
                    @if($notice->is_important)
                    <div style="width:40px;height:40px;background:rgba(239,68,68,.1);border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="bi bi-exclamation-circle-fill" style="color:var(--danger)"></i></div>
                    @else
                    <div style="width:40px;height:40px;background:var(--primary-light);border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="bi bi-megaphone-fill" style="color:var(--primary)"></i></div>
                    @endif
                    <div>
                        <div style="font-weight:600;font-size:.875rem">{{ Str::limit($notice->title,45) }}</div>
                        <div style="font-size:.75rem;color:var(--text-muted)">{{ $notice->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                @empty<div class="text-center py-3" style="color:var(--text-muted);font-size:.85rem">No notices</div>@endforelse
            </div>
        </div>
    </div>

    <!-- Fee Status -->
    <div class="col-lg-6 animate-slide-up anim-delay-3">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-cash me-2 text-primary-sc"></i>Fee Status</h5><a href="{{ route('student.fees') }}" class="sc-badge badge-primary">Details</a></div>
            <div class="card-body-sc">
                @if($student->fees_due > 0)
                <div class="sc-alert danger mb-3"><i class="bi bi-exclamation-triangle-fill"></i> <strong>Fee Due:</strong> â‚¹{{ number_format($student->fees_due) }} pending payment</div>
                @else
                <div class="sc-alert success mb-3"><i class="bi bi-check-circle-fill"></i> All fees are cleared! Great!</div>
                @endif
                <div class="sc-table-wrapper"><table class="sc-table"><thead><tr><th>Receipt</th><th>Amount</th><th>Date</th><th>Status</th></tr></thead><tbody>
                @forelse($feePayments->take(4) as $p)
                <tr><td><code style="font-size:.72rem;color:var(--primary)">{{ $p->receipt_number }}</code></td><td style="font-weight:700;color:var(--success)">â‚¹{{ number_format($p->amount_paid) }}</td><td style="font-size:.75rem;color:var(--text-muted)">{{ \Carbon\Carbon::parse($p->payment_date)->format('d M Y') }}</td><td><span class="sc-badge badge-success">{{ ucfirst($p->status) }}</span></td></tr>
                @empty<tr><td colspan="4" class="text-center py-3" style="color:var(--text-muted)">No payments yet</td></tr>@endforelse
                </tbody></table></div>
            </div>
        </div>
    </div>

    <!-- Pending Assignments -->
    <div class="col-lg-6 animate-slide-up anim-delay-4">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-clipboard-check me-2 text-primary-sc"></i>Assignments</h5><a href="{{ route('student.assignments') }}" class="sc-badge badge-primary">View All</a></div>
            <div class="card-body-sc">
                @forelse($assignments->take(4) as $a)
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom:1px solid var(--border)">
                    <div>
                        <div style="font-weight:600;font-size:.875rem">{{ Str::limit($a->title,35) }}</div>
                        <div style="font-size:.75rem;color:var(--text-muted)">{{ $a->subject->name ?? '-' }}</div>
                    </div>
                    <div class="text-end">
                        <div style="font-size:.7rem;color:{{ now()->gt($a->due_date)?'var(--danger)':'var(--text-muted)' }};font-weight:600"><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($a->due_date)->format('d M') }}</div>
                        <span class="sc-badge {{ now()->gt($a->due_date)?'badge-danger':'badge-warning' }}" style="font-size:.62rem">{{ now()->gt($a->due_date)?'Overdue':'Pending' }}</span>
                    </div>
                </div>
                @empty<div class="text-center py-3" style="color:var(--text-muted)"><i class="bi bi-check-all text-success me-1"></i>No pending assignments!</div>@endforelse
            </div>
        </div>
    </div>
</div>
@endsection

