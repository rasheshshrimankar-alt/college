@extends('layouts.dashboard')
@section('title','Timetable')
@section('page_title','Timetable')
@section('breadcrumb')<a href="{{ route('student.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Timetable</span>@endsection
@section('sidebar')@include('student.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div>
        <h1 class="page-title">Class Timetable</h1>
        <p style="color:var(--text-muted);font-size:.875rem">{{ $student->course->name ?? 'Course' }} — Semester {{ $student->current_semester ?? 1 }}</p>
    </div>
</div>

<div class="dashboard-card animate-slide-up">
    <div class="card-header-sc">
        <h5><i class="bi bi-calendar-week me-2 text-primary-sc"></i>Weekly Schedule</h5>
        <span class="sc-badge badge-primary">{{ now()->format('W') }}th Week</span>
    </div>
    <div class="card-body-sc" style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse;min-width:700px">
            <thead>
                <tr>
                    <th style="padding:.875rem 1rem;background:var(--gradient-1);color:white;font-size:.78rem;font-weight:700;text-align:left;border-radius:8px 0 0 0">Time</th>
                    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                    <th style="padding:.875rem 1rem;background:var(--gradient-1);color:white;font-size:.78rem;font-weight:700;text-align:center">{{ $day }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php
                $timeSlots = ['9:00 – 10:00','10:00 – 11:00','11:00 – 12:00','12:00 – 1:00 (Break)','1:00 – 2:00','2:00 – 3:00','3:00 – 4:00'];
                $subjects  = ['Data Structures','DBMS','OS','Networks','Algorithms','Maths','Physics'];
                $colors    = ['rgba(49,87,213,.1)','rgba(120,86,216,.1)','rgba(72,185,245,.1)','rgba(34,197,94,.1)','rgba(245,158,11,.1)','rgba(239,68,68,.1)'];
                $tColors   = ['var(--primary)','var(--secondary)','var(--accent)','var(--success)','var(--warning)','var(--danger)'];
                @endphp
                @foreach($timeSlots as $ti => $time)
                @php $isBreak = str_contains($time, 'Break'); @endphp
                <tr style="background:{{ $ti%2==0?'var(--bg)':'var(--card)' }}">
                    <td style="padding:.75rem 1rem;font-size:.8rem;font-weight:600;color:var(--text-muted);white-space:nowrap;border-bottom:1px solid var(--border)">{{ $time }}</td>
                    @if($isBreak)
                    <td colspan="6" style="padding:.75rem 1rem;text-align:center;background:rgba(245,158,11,.06);border-bottom:1px solid var(--border)">
                        <span style="font-size:.8rem;font-weight:700;color:var(--warning)"><i class="bi bi-cup-hot me-1"></i>Lunch Break</span>
                    </td>
                    @else
                    @foreach(['Mon','Tue','Wed','Thu','Fri','Sat'] as $di => $day)
                    @php
                    $hasClass = !($ti == 0 && $di == 5) && !($ti == 2 && $di == 5);
                    $subIdx   = ($ti + $di) % count($subjects);
                    @endphp
                    <td style="padding:.75rem 1rem;border-bottom:1px solid var(--border);text-align:center">
                        @if($hasClass)
                        <div style="background:{{ $colors[$subIdx % count($colors)] }};border-radius:8px;padding:.5rem .75rem;display:inline-block;min-width:100px">
                            <div style="font-size:.75rem;font-weight:700;color:{{ $tColors[$subIdx % count($tColors)] }}">{{ $subjects[$subIdx] }}</div>
                            <div style="font-size:.65rem;color:var(--text-muted)">Room {{ 100 + $subIdx }}</div>
                        </div>
                        @else
                        <span style="font-size:.72rem;color:var(--text-muted)">—</span>
                        @endif
                    </td>
                    @endforeach
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-body-sc" style="border-top:1px solid var(--border)">
        <div style="font-size:.78rem;color:var(--text-muted)"><i class="bi bi-info-circle me-1"></i>Timetable is for reference. Please check department notice board for any changes.</div>
    </div>
</div>
@endsection
