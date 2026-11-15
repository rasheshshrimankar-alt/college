<?php

namespace App\\Http\\Controllers\\Student;

use App\\Http\\Controllers\\Controller;
use App\\Models\\Assignment;
use App\\Models\\AssignmentSubmission;
use App\\Notifications\\AssignmentSubmitted;
use Illuminate\\Http\\Request;
use Illuminate\\Support\\Facades\\Storage;

class AssignmentSubmissionController extends Controller
{
    public function store(Request $request, Assignment $assignment)
    {
        $student = $request->user()->student;

        abort_unless($student, 403, 'Student profile not found.');
        abort_unless(
            $assignment->status === 'active'
            && (int) $assignment->course_id === (int) $student->course_id
            && (int) $assignment->semester === (int) $student->current_semester,
            403,
            'This assignment is not available for your course or semester.'
        );

        $validated = $request->validate([
            'submission_file' => 'required|file|mimes:pdf,doc,docx,zip,jpg,jpeg,png|max:10240',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $submission = AssignmentSubmission::firstOrNew([
            'assignment_id' => $assignment->id,
            'student_id' => $student->id,
        ]);

        if ($submission->exists && $submission->status === 'graded') {
            return back()->withErrors(['submission_file' => 'This submission has already been graded.']);
        }

        if ($submission->file_path) {
            Storage::disk('public')->delete($submission->file_path);
        }

        $submission->file_path = $request->file('submission_file')->store('assignment-submissions/' . $student->id, 'public');
        $submission->remarks = $validated['remarks'] ?? null;
        $submission->status = now()->gt($assignment->due_date) ? 'late' : 'submitted';
        $submission->submitted_at = now();
        $submission->save();

        $assignment->loadMissing('faculty.user');
        $assignment->faculty?->user?->notify(new AssignmentSubmitted(
            $assignment->id,
            $assignment->title,
            $request->user()->name
        ));

        return back()->with('success', 'Assignment submitted successfully.');
    }
}
