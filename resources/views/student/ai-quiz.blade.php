@extends('layouts.dashboard')
@section('title', 'AI Quiz Generator')
@section('page_title', 'AI Quiz Generator')
@section('breadcrumb')<span>AI Quiz Generator</span>@endsection
@section('sidebar')@include('student.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div>
        <h1 class="page-title"><i class="bi bi-stars me-2"></i>AI Quiz Generator</h1>
        <p class="text-muted mb-0">Create practice questions for a topic you are studying.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5 class="mb-0">Build your practice quiz</h5></div>
            <div class="card-body-sc">
                <form method="POST" action="{{ route('student.quiz.generate') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="topic" class="form-label fw-semibold">Subject or topic</label>
                        <input id="topic" name="topic" class="form-control" maxlength="160" minlength="3" value="{{ old('topic', $topic ?? '') }}" placeholder="Example: Object-oriented programming" required>
                    </div>
                    <div class="mb-3">
                        <label for="difficulty" class="form-label fw-semibold">Difficulty</label>
                        <select id="difficulty" name="difficulty" class="form-select" required>
                            @foreach(['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('difficulty', $difficulty ?? 'beginner') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="question_count" class="form-label fw-semibold">Number of questions</label>
                        <select id="question_count" name="question_count" class="form-select" required>
                            @foreach([5, 6, 8, 10] as $count)
                                <option value="{{ $count }}" @selected((int) old('question_count', 5) === $count)>{{ $count }} questions</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary w-100" type="submit"><i class="bi bi-magic me-2"></i>Generate practice quiz</button>
                    <p class="small text-muted mt-3 mb-0">Use these questions to practise. Always verify important facts with your class notes and teacher.</p>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        @isset($questions)
            <div class="dashboard-card">
                <div class="card-header-sc d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $topic }} — {{ ucfirst($difficulty) }}</h5>
                    <span class="sc-badge badge-primary">{{ count($questions) }} questions</span>
                </div>
                <div class="card-body-sc">
                    @foreach($questions as $index => $question)
                        <article class="border rounded-3 p-3 mb-3">
                            <h6 class="fw-bold">{{ $index + 1 }}. {{ $question['question'] }}</h6>
                            <ol type="A" class="mb-3">
                                @foreach($question['options'] as $option)
                                    <li class="mb-1">{{ $option }}</li>
                                @endforeach
                            </ol>
                            <details>
                                <summary class="text-primary fw-semibold" style="cursor:pointer">Show answer and explanation</summary>
                                <div class="mt-2 p-3 rounded-3 bg-light">
                                    <div><strong>Answer:</strong> {{ $question['answer'] }}</div>
                                    <div class="mt-1"><strong>Why:</strong> {{ $question['explanation'] }}</div>
                                </div>
                            </details>
                        </article>
                    @endforeach
                    <button type="button" class="btn btn-outline-primary" onclick="window.print()"><i class="bi bi-printer me-2"></i>Print quiz</button>
                </div>
            </div>
        @else
            <div class="dashboard-card h-100">
                <div class="card-body-sc text-center py-5">
                    <i class="bi bi-journal-check display-3 text-primary"></i>
                    <h5 class="mt-3">Your practice quiz will appear here</h5>
                    <p class="text-muted mb-0">Choose a topic, difficulty and question count to get started.</p>
                </div>
            </div>
        @endisset
    </div>
</div>
@endsection
