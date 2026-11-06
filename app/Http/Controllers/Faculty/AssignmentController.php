<?php
namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index()
    {
        $faculty     = auth()->user()->faculty;
        $assignments = Assignment::where('faculty_id', $faculty->id)
            ->with('subject', 'course')
            ->withCount('submissions')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('faculty.assignments.index', compact('assignments', 'faculty'));
    }

    public function create()
    {
        $faculty  = auth()->user()->faculty;
        $subjects = Subject::where('department_id', $faculty->department_id)->get();
        $courses  = Course::where('department_id', $faculty->department_id)->where('status', 'active')->get();
        return view('faculty.assignments.create', compact('subjects', 'courses', 'faculty'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required',
            'subject_id' => 'required|exists:subjects,id',
            'course_id'  => 'required|exists:courses,id',
            'due_date'   => 'required|date',
            'max_marks'  => 'required|numeric',
        ]);

        $faculty = auth()->user()->faculty;

        Assignment::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'subject_id'   => $request->subject_id,
            'course_id'    => $request->course_id,
            'department_id'=> $faculty->department_id,
            'faculty_id'   => $faculty->id,
            'due_date'     => $request->due_date,
            'max_marks'    => $request->max_marks,
            'semester'     => $request->semester ?? 1,
            'status'       => 'active',
        ]);

        return redirect()->route('faculty.assignments.index')->with('success', 'Assignment created!');
    }

    public function edit(Assignment $assignment)
    {
        $faculty  = auth()->user()->faculty;
        $subjects = Subject::where('department_id', $faculty->department_id)->get();
        $courses  = Course::where('department_id', $faculty->department_id)->where('status', 'active')->get();
        return view('faculty.assignments.edit', compact('assignment', 'subjects', 'courses', 'faculty'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $request->validate([
            'title'    => 'required',
            'due_date' => 'required|date',
        ]);

        $assignment->update($request->only(['title', 'description', 'due_date', 'max_marks', 'status']));
        return redirect()->route('faculty.assignments.index')->with('success', 'Assignment updated!');
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('faculty.assignments.index')->with('success', 'Assignment deleted!');
    }
}
