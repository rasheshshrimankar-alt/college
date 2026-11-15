<?php

namespace App\\Http\\Controllers\\Faculty;

use App\\Http\\Controllers\\Controller;
use App\\Models\\Assignment;
use App\\Models\\AssignmentSubmission;
use App\\Notifications\\AssignmentGraded;
use Illuminate\\Http\\Request;
use Illuminate\\Support\\Facades\\Storage;

class AssignmentReviewController extends Controller
{
    public function index(Assignment $assignment)
    {
        $faculty = auth()->user()->faculty;
        abort_unless($faculty && (int) $assignment->faculty_id === (int) $faculty->id, 403);

        $submissions = $assignment->submissions()
            ->with('student.user')
            ->orderByDesc('submitted_at')
            ->paginate(20);

        return view('faculty.assignments.submissions', compact('assignment', 'submissions'));
    }

    public function grade(Request $request, Assignment $assignment, AssignmentSubmission $submission)
    {
        $faculty = $request->user()->faculty;
        abort_unless($faculty && (int) $assignment->faculty_id === (int) $faculty->id, 403);
        abort_unless((int) $submission->assignment_id === (int) $assignment->id, 404);

        $validated = $request->validate([
            'marks_obtained' => 'required|numeric|min:0|max:' . (float) ($assignment->max_marks ?? $assignment->total_marks),
            'feedback' => 'nullable|string|max:2000',
        ]);

        $submission->update([
            'marks_obtained' => $validated['marks_obtained'],
            'remarks' => $validated['feedback'] ?? $submission->remarks,
            'status' => 'graded',
        ]);

        $submission->loadMissing('student.user');
        $submission->student?->user?->notify(new AssignmentGraded(
            $assignment->title,
            (float) $validated['marks_obtained'],
            (float) ($assignment->max_marks ?? $assignment->total_marks)
        ));

        return back()->with('success', 'Submission graded successfully.');
    }

    public function download(Assignment $assignment, AssignmentSubmission $submission)
    {
        $faculty = auth()->user()->faculty;
        abort_unless($faculty && (int) $assignment->faculty_id === (int) $faculty->id, 403);
        abort_unless((int) $submission->assignment_id === (int) $assignment->id, 404);
        abort_unless($submission->file_path && Storage::disk('public')->exists($submission->file_path), 404);

        return Storage::disk('public')->download($submission->file_path);
    }
}
