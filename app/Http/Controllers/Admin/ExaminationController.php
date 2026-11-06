<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Examination;
use App\Models\Course;
use App\Models\Department;
use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExaminationController extends Controller
{
    public function index(Request $request)
    {
        $query = Examination::with('course', 'department');
        if ($request->status) $query->where('status', $request->status);
        $examinations = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.examinations.index', compact('examinations'));
    }

    public function create()
    {
        $courses     = Course::where('status', 'active')->get();
        $departments = Department::where('status', 'active')->get();
        return view('admin.examinations.create', compact('courses', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'course_id'     => 'required',
            'department_id' => 'required',
            'exam_type'     => 'required',
            'semester'      => 'required',
            'academic_year' => 'required',
            'total_marks'   => 'required|integer',
            'passing_marks' => 'required|integer',
        ]);

        Examination::create(
            $request->only('name', 'course_id', 'department_id', 'exam_type', 'semester', 'academic_year', 'start_date', 'end_date', 'total_marks', 'passing_marks', 'status', 'description')
        );

        return redirect()->route('admin.examinations.index')->with('success', 'Examination created!');
    }

    public function edit(Examination $examination)
    {
        $courses     = Course::get();
        $departments = Department::get();
        return view('admin.examinations.edit', compact('examination', 'courses', 'departments'));
    }

    public function update(Request $request, Examination $examination)
    {
        $request->validate([
            'name'      => 'required',
            'course_id' => 'required',
        ]);

        $examination->update(
            $request->only('name', 'course_id', 'department_id', 'exam_type', 'semester', 'academic_year', 'start_date', 'end_date', 'total_marks', 'passing_marks', 'status', 'description')
        );

        return redirect()->route('admin.examinations.index')->with('success', 'Examination updated!');
    }

    public function destroy(Examination $examination)
    {
        $examination->delete();
        return redirect()->route('admin.examinations.index')->with('success', 'Examination deleted!');
    }

    public function results(Examination $examination)
    {
        $results = Result::with('student.user', 'subject')
            ->where('examination_id', $examination->id)
            ->paginate(20);
        return view('admin.examinations.results', compact('examination', 'results'));
    }
}
