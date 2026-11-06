<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\Event;
use App\Models\Examination;
use App\Models\Result;
use App\Models\Attendance;
use App\Models\FeePayment;
use App\Models\Assignment;
use App\Models\StudyMaterial;
use App\Models\LibraryBook;
use App\Models\BookIssue;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        if (!$student) {
            return redirect()->route('login')->with('error', 'Student profile not found.');
        }
        $student->load('course', 'department');

        $totalClasses   = Attendance::where('student_id', $student->id)->count();
        $totalPresent   = Attendance::where('student_id', $student->id)->where('status', 'present')->count();
        $attendancePercent = $totalClasses > 0 ? round(($totalPresent / $totalClasses) * 100, 1) : 0;

        $recentResults = Result::where('student_id', $student->id)
            ->with('examination', 'subject')
            ->orderBy('created_at', 'desc')
            ->take(5)->get();

        $avgPercentage = $recentResults->avg('percentage') ?? 0;

        $upcomingExams = Examination::where('course_id', $student->course_id)
            ->where('status', 'upcoming')
            ->orderBy('start_date')->take(4)->get();

        $recentNotices = Notice::where('status', 'active')
            ->whereIn('target', ['all', 'students'])
            ->orderBy('is_important', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)->get();

        $feePayments = FeePayment::where('student_id', $student->id)
            ->orderBy('created_at', 'desc')->take(5)->get();

        $assignments = Assignment::where('course_id', $student->course_id)
            ->with('subject')->orderBy('due_date')->take(5)->get();

        $pendingAssignments = $assignments->count();

        return view('student.dashboard', compact(
            'student', 'totalClasses', 'totalPresent', 'attendancePercent',
            'recentResults', 'avgPercentage', 'upcomingExams', 'recentNotices',
            'feePayments', 'assignments', 'pendingAssignments'
        ));
    }

    public function profile()
    {
        $student = auth()->user()->student->load('user', 'course', 'department');
        return view('student.profile', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'phone'      => 'required',
            'address'    => 'nullable',
            'blood_group'=> 'nullable',
        ]);

        $student = auth()->user()->student;
        $student->user->update(['phone' => $request->phone]);
        $student->update([
            'phone'       => $request->phone,
            'address'     => $request->address,
            'blood_group' => $request->blood_group,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function assignments()
    {
        $student = auth()->user()->student;
        $assignments = Assignment::where('course_id', $student->course_id)
            ->with('subject', 'faculty.user')
            ->orderBy('due_date', 'asc')
            ->paginate(15);
        return view('student.assignments', compact('assignments', 'student'));
    }

    public function materials()
    {
        $student = auth()->user()->student;
        $materials = StudyMaterial::where('course_id', $student->course_id)
            ->orWhere('department_id', $student->department_id)
            ->with('subject', 'faculty.user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('student.materials', compact('materials', 'student'));
    }

    public function notices()
    {
        $notices = Notice::where('status', 'active')
            ->whereIn('target', ['all', 'students'])
            ->orderBy('is_important', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('student.notices', compact('notices'));
    }

    public function library()
    {
        $student = auth()->user()->student;
        $books = LibraryBook::where('status', 'available')->paginate(12);
        $myIssues = BookIssue::where('student_id', $student->id)
            ->with('book')->orderBy('issue_date', 'desc')->get();
        return view('student.library', compact('books', 'myIssues', 'student'));
    }

    public function scholarship()
    {
        $scholarships = Scholarship::where('status', 'active')
            ->orderBy('amount', 'desc')->get();
        return view('student.scholarship', compact('scholarships'));
    }

    public function timetable()
    {
        $student = auth()->user()->student->load('course', 'department');
        return view('student.timetable', compact('student'));
    }
}
