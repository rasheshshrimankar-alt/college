<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Student ID Verification | Smart Campus</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<main class="container py-5">
    <div class="card border-0 shadow-sm mx-auto" style="max-width:480px;border-radius:18px">
        <div class="card-body p-4 text-center">
            <div class="text-primary fw-bold small mb-2">SMART CAMPUS</div>
            @if($student->status === 'active')
                <div class="badge text-bg-success mb-3">Verified student</div>
            @else
                <div class="badge text-bg-secondary mb-3">Not currently active</div>
            @endif
            <h1 class="h4">{{ $student->user->name }}</h1>
            <p class="text-muted mb-4">Student identity verification</p>
            <div class="text-start border rounded-3 p-3">
                <div class="small text-muted">Student ID</div><div class="fw-semibold mb-2">{{ $student->student_id }}</div>
                <div class="small text-muted">Course</div><div class="fw-semibold mb-2">{{ $student->course->name ?? '-' }}</div>
                <div class="small text-muted">Department</div><div class="fw-semibold mb-2">{{ $student->department->name ?? '-' }}</div>
                <div class="small text-muted">Status</div><div class="fw-semibold">{{ ucfirst($student->status) }}</div>
            </div>
            <p class="small text-muted mt-3 mb-0">This page confirms the student record only. It does not confirm attendance or exam eligibility.</p>
        </div>
    </div>
</main>
</body>
</html>
