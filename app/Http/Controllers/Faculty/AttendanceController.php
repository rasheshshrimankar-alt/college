<?php
namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $faculty  = auth()->user()->faculty;
        $subjects = Subject::where('faculty_id', $faculty->id)->get();

        $query = Attendance::where('faculty_id', $faculty->id)->with('student.user', 'subject');
        if ($request->subject_id) $query->where('subject_id', $request->subject_id);
        if ($request->date)       $query->whereDate('date', $request->date);

        $attendance = $query->orderBy('date', 'desc')->paginate(20)->withQueryString();

        return view('faculty.attendance.index', compact('attendance', 'subjects'));
    }

    public function markForm(Request $request)
    {
        $faculty  = auth()->user()->faculty;
        $subjects = Subject::where('faculty_id', $faculty->id)->get();

        $subjectId = $request->subject_id ?? $subjects->first()?->id;
        $students  = $subjectId
            ? Student::where('course_id', Subject::find($subjectId)?->course_id)
                ->where('status', 'active')
                ->with('user')
                ->get()
            : collect();

        return view('faculty.attendance.mark', compact('subjects', 'students', 'subjectId'));
    }

    public function markStore(Request $request)
    {
        $request->validate([
            'subject_id'  => 'required|exists:subjects,id',
            'date'        => 'required|date',
            'attendance'  => 'required|array',
        ]);

        $faculty = auth()->user()->faculty;

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'subject_id' => $request->subject_id, 'date' => $request->date],
                ['status' => $status, 'faculty_id' => $faculty->id]
            );
        }

        return redirect()->route('faculty.attendance.index')->with('success', 'Attendance marked successfully!');
    }

    public function report(Request $request)
    {
        $faculty  = auth()->user()->faculty;
        $subjects = Subject::where('faculty_id', $faculty->id)->get();

        $subjectId = $request->subject_id;
        $students  = collect();

        if ($subjectId) {
            $subject  = Subject::findOrFail($subjectId);
            $students = Student::where('course_id', $subject->course_id)
                ->where('status', 'active')
                ->with(['user', 'attendance' => fn($q) => $q->where('subject_id', $subjectId)])
                ->get();
        }

        return view('faculty.attendance.report', compact('subjects', 'students', 'subjectId'));
    }
}
