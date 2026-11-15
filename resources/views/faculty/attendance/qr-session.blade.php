@extends('layouts.dashboard')
@section('title','QR Attendance')
@section('page_title','QR Attendance')
@section('sidebar')@include('faculty.partials.sidebar')@endsection
@section('content')
<div class="page-header">
    <div><h1 class="page-title">QR Attendance</h1><p style="color:var(--text-muted)">{{ $subject->name }} — Semester {{ $session->semester }}</p></div>
    <a href="{{ route('faculty.attendance.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a>
</div>
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-5">
        <div class="dashboard-card p-4 text-center">
            <span class="sc-badge badge-success mb-3">Active for 10 minutes</span>
            <h5 class="fw-bold">Students: scan this QR code</h5>
            <p class="text-muted small">Students must be signed in and enrolled in this course and semester.</p>
            <div id="attendanceQr" class="d-inline-block p-3 bg-white rounded-3 my-3"></div>
            <div class="small text-muted">Session expires at {{ $session->expires_at->format('h:i A') }}</div>
            <div class="mt-3"><a href="{{ $scanUrl }}" class="small" target="_blank" rel="noopener">Open attendance link</a></div>
            <div class="alert alert-warning text-start small mt-3 mb-0">Only one attendance record per student, subject and date is saved. A previously recorded absence will not be overwritten by scanning.</div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const target = document.getElementById('attendanceQr');
    if (target && window.QRCode) {
        new QRCode(target, { text: @json($scanUrl), width: 220, height: 220, correctLevel: QRCode.CorrectLevel.M });
    }
});
</script>
@endpush
