<?php
namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Attendance;
use App\Models\Result;
use App\Models\Examination;
use App\Models\Notice;
use App\Models\Assignment;
use App\Models\StudyMaterial;
use App\Models\Complaint;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $faculty = auth()->user()->faculty;
        if (!$faculty) {
            return redirect()->route('login')->with('error', 'Faculty profile not found.');
        }

        $myStudents      = Student::where('department_id', $faculty->department_id)->where('status', 'active')->count();
        $myAssignments   = Assignment::where('faculty_id', $faculty->id)->count();
        $resultsEntered  = Result::where('faculty_id', $faculty->id)->count();
        $myMaterials     = StudyMaterial::where('faculty_id', $faculty->id)->count();

        $recentStudents = Student::where('department_id', $faculty->department_id)
            ->where('status', 'active')
            ->with('user', 'course')
            ->orderBy('created_at', 'desc')
            ->take(8)->get();

        $recentAssignments = Assignment::where('faculty_id', $faculty->id)
            ->with('subject')
            ->withCount('submissions')
            ->orderBy('created_at', 'desc')
            ->take(5)->get();

        $recentNotices = Notice::where('status', 'active')
            ->whereIn('target', ['all', 'faculty'])
            ->orderBy('created_at', 'desc')
            ->take(5)->get();

        return view('faculty.dashboard', compact(
            'faculty', 'myStudents', 'myAssignments', 'resultsEntered', 'myMaterials',
            'recentStudents', 'recentAssignments', 'recentNotices'
        ));
    }

    public function profile()
    {
        $faculty = auth()->user()->faculty->load('user', 'department');
        return view('faculty.profile', compact('faculty'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate(['phone' => 'required']);
        $faculty = auth()->user()->faculty;
        $faculty->user->update(['phone' => $request->phone]);
        $faculty->update(['specialization' => $request->specialization]);
        return back()->with('success', 'Profile updated!');
    }

    public function students()
    {
        $faculty  = auth()->user()->faculty;
        $students = Student::where('department_id', $faculty->department_id)
            ->where('status', 'active')
            ->with('user', 'course')
            ->paginate(15);
        return view('faculty.students', compact('students', 'faculty'));
    }

    public function notices()
    {
        $notices = Notice::where('status', 'active')
            ->whereIn('target', ['all', 'faculty'])
            ->orderBy('is_important', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('faculty.notices', compact('notices'));
    }

    public function complaints()
    {
        $faculty    = auth()->user()->faculty;
        $complaints = Complaint::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('faculty.complaints', compact('complaints', 'faculty'));
    }

    public function salary()
    {
        $faculty = auth()->user()->faculty->load('user', 'department');
        return view('faculty.salary', compact('faculty'));
    }
}
