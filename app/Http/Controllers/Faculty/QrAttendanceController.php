<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QrAttendanceController extends Controller
{
    public function create(Request $request)
    {
        $request->validate(['subject_id' => 'required|integer|exists:subjects,id']);

        $faculty = $request->user()->faculty;
        abort_unless($faculty, 403);

        $subject = $faculty->subjects()
            ->where('subjects.id', $request->subject_id)
            ->firstOrFail();

        $session = AttendanceSession::create([
            'faculty_id' => $faculty->id,
            'subject_id' => $subject->id,
            'course_id' => $subject->course_id,
            'semester' => (int) ($subject->pivot->semester ?? $subject->semester),
            'academic_year' => $subject->pivot->academic_year ?? (now()->year . '-' . (now()->year + 1)),
            'token' => Str::random(64),
            'expires_at' => now()->addMinutes(10),
        ]);

        $scanUrl = route('student.attendance.scan', $session->token);

        return view('faculty.attendance.qr-session', compact('session', 'subject', 'scanUrl'));
    }

    public function scan(Request $request, string $token)
    {
        $student = $request->user()->student;
        abort_unless($student, 403, 'Student profile not found.');

        $session = AttendanceSession::with('subject')
            ->where('token', $token)
            ->firstOrFail();

        if ($session->expires_at->isPast()) {
            return redirect()->route('student.attendance.index')->with('error', 'This QR attendance session has expired.');
        }

        abort_unless(
            (int) $student->course_id === (int) $session->course_id
            && (int) $student->current_semester === (int) $session->semester,
            403,
            'This QR code is not for your course or semester.'
        );

        $attendance = Attendance::firstOrCreate(
            [
                'student_id' => $student->id,
                'subject_id' => $session->subject_id,
                'date' => today()->toDateString(),
            ],
            [
                'faculty_id' => $session->faculty_id,
                'status' => 'present',
                'academic_year' => $session->academic_year,
                'semester' => $session->semester,
                'remarks' => 'Marked through QR attendance',
            ]
        );

        $message = $attendance->wasRecentlyCreated
            ? 'Your attendance has been recorded.'
            : 'Attendance for this subject is already recorded today.';

        return redirect()->route('student.attendance.index')->with('success', $message);
    }
}
