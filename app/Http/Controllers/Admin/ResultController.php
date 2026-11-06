<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Student;
use App\Models\Examination;
use App\Models\Subject;
use App\Models\Faculty;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $query = Result::with('student.user', 'examination', 'subject');
        if ($request->examination_id) $query->where('examination_id', $request->examination_id);

        $results      = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $examinations = Examination::all();

        return view('admin.results.index', compact('results', 'examinations'));
    }

    public function create()
    {
        $students     = Student::with('user')->get();
        $examinations = Examination::all();
        $subjects     = Subject::all();
        return view('admin.results.create', compact('students', 'examinations', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id'     => 'required',
            'examination_id' => 'required',
            'subject_id'     => 'required',
            'marks_obtained' => 'required|numeric',
            'total_marks'    => 'required|numeric',
        ]);

        $percentage = ($request->marks_obtained / $request->total_marks) * 100;
        $exam       = Examination::find($request->examination_id);

        Result::create([
            'student_id'     => $request->student_id,
            'examination_id' => $request->examination_id,
            'subject_id'     => $request->subject_id,
            'marks_obtained' => $request->marks_obtained,
            'total_marks'    => $request->total_marks,
            'percentage'     => $percentage,
            'status'         => $request->marks_obtained >= $exam->passing_marks ? 'pass' : 'fail',
            'faculty_id'     => auth()->user()->faculty?->id,
        ]);

        return redirect()->route('admin.results.index')->with('success', 'Result added!');
    }

    public function destroy(Result $result)
    {
        $result->delete();
        return redirect()->route('admin.results.index')->with('success', 'Result deleted!');
    }
}
