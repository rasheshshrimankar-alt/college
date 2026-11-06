@extends('layouts.dashboard')
@section('title','Enter Results')
@section('sidebar')@include('faculty.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Enter Results</h1></div>
    <a href="{{ route('faculty.results.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a>
</div>
<div class="row justify-content-center animate-slide-up"><div class="col-lg-10">
<div class="dashboard-card">
    <div class="card-header-sc"><h5><i class="bi bi-graph-up me-2 text-primary-sc"></i>Bulk Result Entry</h5></div>
    <div class="card-body-sc">
    <form method="POST" action="{{ route('faculty.results.store') }}" data-validate>@csrf
        <div class="row g-3 mb-4">
            <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Examination <span class="text-danger">*</span></label><select name="examination_id" class="sc-select {{ $errors->has('examination_id')?'is-invalid':'' }}" required><option value="">Select Examination</option>@foreach($examinations as $e)<option value="{{ $e->id }}" {{ old('examination_id')==$e->id?'selected':'' }}>{{ $e->name }} (Max: {{ $e->total_marks }} | Pass: {{ $e->passing_marks }})</option>@endforeach</select></div></div>
            <div class="col-md-6"><div class="sc-form-group"><label class="sc-label">Subject <span class="text-danger">*</span></label><select name="subject_id" class="sc-select {{ $errors->has('subject_id')?'is-invalid':'' }}" required><option value="">Select Subject</option>@foreach($subjects as $s)<option value="{{ $s->id }}" {{ old('subject_id')==$s->id?'selected':'' }}>{{ $s->name }} ({{ $s->code }})</option>@endforeach</select></div></div>
        </div>
        <div style="font-size:.82rem;color:var(--text-muted);margin-bottom:1rem;padding:.75rem;background:rgba(49,87,213,.05);border-radius:8px"><i class="bi bi-info-circle me-1 text-primary"></i>Leave marks blank to skip a student. Passing marks are defined per examination.</div>
        @php $students = App\Models\Student::where('status','active')->with('user')->orderBy('roll_number')->get(); @endphp
        <div class="sc-table-wrapper"><table class="sc-table">
            <thead><tr><th>#</th><th>Student</th><th>ID</th><th>Marks Obtained</th></tr></thead>
            <tbody>
            @foreach($students as $i => $s)
            <tr>
                <td style="color:var(--text-muted);font-size:.78rem">{{ $i+1 }}</td>
                <td style="font-weight:600;font-size:.875rem">{{ $s->user->name ?? '-' }}</td>
                <td><code style="font-size:.72rem;color:var(--primary);background:var(--primary-light);padding:1px 5px;border-radius:4px">{{ $s->student_id }}</code></td>
                <td><input type="number" name="results[{{ $s->id }}][marks_obtained]" class="sc-input" style="max-width:130px" min="0" step="0.5" placeholder="Enter marks"></td>
            </tr>
            @endforeach
            </tbody>
        </table></div>
        <div class="mt-4 d-flex gap-2"><button type="submit" class="btn-primary-sc"><i class="bi bi-check-lg me-2"></i>Save All Results</button><a href="{{ route('faculty.results.index') }}" class="btn-outline-sc">Cancel</a></div>
    </form>
    </div>
</div>
</div></div>
@endsection
