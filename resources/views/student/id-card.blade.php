@extends('layouts.dashboard')
@section('title','Digital Student ID')
@section('page_title','Digital Student ID')
@section('sidebar')@include('student.partials.sidebar')@endsection
@section('content')
<div class="page-header">
    <div><h1 class="page-title">Digital Student ID</h1><p style="color:var(--text-muted)">Your college identity card with secure QR verification</p></div>
    <button class="btn-primary-sc" type="button" onclick="window.print()"><i class="bi bi-printer me-1"></i>Print ID</button>
</div>
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-5">
        <div class="dashboard-card p-4" id="studentIdCard" style="border:1px solid var(--border);border-radius:18px">
            <div class="text-center pb-3 mb-3" style="border-bottom:2px solid var(--primary)">
                <div style="font-size:.75rem;font-weight:800;letter-spacing:2px;color:var(--primary)">SMART CAMPUS</div>
                <div class="fw-bold fs-5">STUDENT IDENTITY CARD</div>
            </div>
            <div class="d-flex align-items-center gap-3 mb-3">
                <img src="{{ $student->profile_photo_url }}" alt="Student photo" style="width:88px;height:104px;object-fit:cover;border-radius:10px;border:1px solid var(--border)">
                <div>
                    <div class="fw-bold fs-5">{{ $student->user->name }}</div>
                    <div class="small text-muted">{{ $student->course->name ?? 'Course not assigned' }}</div>
                    <span class="sc-badge badge-success mt-2">{{ ucfirst($student->status) }}</span>
                </div>
            </div>
            <div class="row g-2 small">
                <div class="col-6"><span class="text-muted">Student ID</span><div class="fw-bold">{{ $student->student_id }}</div></div>
                <div class="col-6"><span class="text-muted">Roll Number</span><div class="fw-bold">{{ $student->roll_number }}</div></div>
                <div class="col-6"><span class="text-muted">Department</span><div class="fw-bold">{{ $student->department->name ?? '-' }}</div></div>
                <div class="col-6"><span class="text-muted">Semester</span><div class="fw-bold">{{ $student->current_semester }}</div></div>
                <div class="col-6"><span class="text-muted">Batch</span><div class="fw-bold">{{ $student->batch_year }}</div></div>
                <div class="col-6"><span class="text-muted">Academic status</span><div class="fw-bold">{{ ucfirst($student->status) }}</div></div>
            </div>
            <div class="text-center mt-4 pt-3" style="border-top:1px dashed var(--border)">
                <div id="studentIdQr" class="d-inline-block p-2 bg-white rounded"></div>
                <div class="small text-muted mt-2">Scan to verify this student ID</div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const target = document.getElementById('studentIdQr');
    if (target && window.QRCode) {
        new QRCode(target, { text: @json($verificationUrl), width: 128, height: 128, correctLevel: QRCode.CorrectLevel.M });
    }
});
</script>
<style>
@media print {
    body * { visibility: hidden !important; }
    #studentIdCard, #studentIdCard * { visibility: visible !important; }
    #studentIdCard { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none !important; }
}
</style>
@endpush
