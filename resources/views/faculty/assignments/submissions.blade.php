@extends('layouts.dashboard')
@section('title','Assignment Submissions')
@section('page_title','Assignment Submissions')
@section('sidebar')@include('faculty.partials.sidebar')@endsection
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $assignment->title }}</h1>
        <p style="color:var(--text-muted)">Review student work and record marks (maximum {{ $assignment->max_marks ?? $assignment->total_marks }})</p>
    </div>
    <a href="{{ route('faculty.assignments.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a>
</div>
@if(session('success'))<div class="sc-alert success mb-3">{{ session('success') }}</div>@endif
@if($errors->any())<div class="sc-alert danger mb-3">{{ $errors->first() }}</div>@endif
<div class="dashboard-card">
    <div class="sc-table-wrapper">
        <table class="sc-table">
            <thead><tr><th>Student</th><th>Submitted</th><th>File</th><th>Status</th><th>Grade / Feedback</th></tr></thead>
            <tbody>
            @forelse($submissions as $submission)
                <tr>
                    <td><strong>{{ $submission->student->user->name ?? 'Student' }}</strong><div class="text-muted small">{{ $submission->student->roll_number ?? '' }}</div></td>
                    <td>{{ $submission->submitted_at?->format('d M Y, h:i A') ?? '-' }}</td>
                    <td>
                        @if($submission->file_path)
                            <a href="{{ asset('storage/'.$submission->file_path) }}" target="_blank" rel="noopener">View file</a>
                        @else - @endif
                    </td>
                    <td><span class="sc-badge {{ $submission->status === 'graded' ? 'badge-success' : ($submission->status === 'late' ? 'badge-danger' : 'badge-warning') }}">{{ ucfirst($submission->status) }}</span></td>
                    <td style="min-width:230px">
                        <form method="POST" action="{{ route('faculty.assignments.grade', [$assignment, $submission]) }}" class="d-flex flex-column gap-2">
                            @csrf @method('PATCH')
                            <input class="sc-input" type="number" name="marks_obtained" min="0" max="{{ $assignment->max_marks ?? $assignment->total_marks }}" step="0.01" value="{{ old('marks_obtained', $submission->marks_obtained) }}" placeholder="Marks" required>
                            <textarea class="sc-input" name="feedback" rows="2" maxlength="2000" placeholder="Feedback">{{ old('feedback', $submission->remarks) }}</textarea>
                            <button class="btn-primary-sc btn-sm-sc" type="submit"><i class="bi bi-check2-circle"></i> Save grade</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-4">No submissions received yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body-sc">{{ $submissions->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
