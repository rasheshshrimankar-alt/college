<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Subject;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $student  = auth()->user()->student;
        $subjects = Subject::where('course_id', $student->course_id)->get();

        $query = Attendance::where('student_id', $student->id)->with('subject');
        if ($request->subject_id) $query->where('subject_id', $request->subject_id);
        if ($request->month)      $query->whereMonth('date', $request->month);

        $attendance = $query->orderBy('date', 'desc')->paginate(20)->withQueryString();

        $summary = [];
        foreach ($subjects as $subject) {
            $total   = Attendance::where('student_id', $student->id)->where('subject_id', $subject->id)->count();
            $present = Attendance::where('student_id', $student->id)->where('subject_id', $subject->id)->where('status', 'present')->count();
            $summary[] = [
                'subject'     => $subject->name,
                'total'       => $total,
                'present'     => $present,
                'percentage'  => $total > 0 ? round(($present / $total) * 100, 1) : 0,
            ];
        }

        return view('student.attendance', compact('attendance', 'subjects', 'summary'));
    }
}
