<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('department')->withCount('students');

        if ($request->search)     $query->where('name', 'like', '%' . $request->search . '%');
        if ($request->department) $query->where('department_id', $request->department);

        $courses     = $query->paginate(10)->withQueryString();
        $departments = Department::where('status', 'active')->get();

        return view('admin.courses.index', compact('courses', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('status', 'active')->get();
        return view('admin.courses.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'               => 'required',
            'code'               => 'required|unique:courses',
            'department_id'      => 'required|exists:departments,id',
            'duration_years'     => 'required|integer',
            'total_semesters'    => 'required|integer',
            'fees_per_semester'  => 'required|numeric',
            'total_seats'        => 'required|integer',
        ]);

        Course::create(
            $request->only('name', 'code', 'department_id', 'description', 'duration_years', 'total_semesters', 'fees_per_semester', 'total_seats')
            + ['status' => 'active']
        );

        return redirect()->route('admin.courses.index')->with('success', 'Course created!');
    }

    public function edit(Course $course)
    {
        $departments = Department::where('status', 'active')->get();
        return view('admin.courses.edit', compact('course', 'departments'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name'          => 'required',
            'code'          => 'required|unique:courses,code,' . $course->id,
            'department_id' => 'required',
        ]);

        $course->update(
            $request->only('name', 'code', 'department_id', 'description', 'duration_years', 'total_semesters', 'fees_per_semester', 'total_seats', 'status')
        );

        return redirect()->route('admin.courses.index')->with('success', 'Course updated!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted!');
    }
}
