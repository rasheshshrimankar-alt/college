<?php
namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Student;
use App\Models\Examination;
use App\Models\Subject;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $faculty      = auth()->user()->faculty;
        $subjects     = Subject::where('faculty_id', $faculty->id)->pluck('id');
        $examinations = Examination::where('department_id', $faculty->department_id)->get();

        $query = Result::with('student.user', 'examination', 'subject')
            ->whereIn('subject_id', $subjects);
        if ($request->examination_id) $query->where('examination_id', $request->examination_id);

        $results = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('faculty.results.index', compact('results', 'examinations'));
    }

    public function create()
    {
        $faculty      = auth()->user()->faculty;
        $subjects     = Subject::where('faculty_id', $faculty->id)->get();
        $examinations = Examination::where('department_id', $faculty->department_id)->get();

        return view('faculty.results.create', compact('subjects', 'examinations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'examination_id' => 'required',
            'subject_id'     => 'required',
            'results'        => 'required|array',
        ]);

        $faculty = auth()->user()->faculty;
        $exam    = Examination::findOrFail($request->examination_id);

        foreach ($request->results as $studentId => $marks) {
            if (!isset($marks['marks_obtained'])) continue;

            $percentage = ($marks['marks_obtained'] / $exam->total_marks) * 100;

            Result::updateOrCreate(
                ['student_id' => $studentId, 'examination_id' => $request->examination_id, 'subject_id' => $request->subject_id],
                [
                    'marks_obtained' => $marks['marks_obtained'],
                    'total_marks'    => $exam->total_marks,
                    'percentage'     => $percentage,
                    'status'         => $marks['marks_obtained'] >= $exam->passing_marks ? 'pass' : 'fail',
                    'faculty_id'     => $faculty->id,
                ]
            );
        }

        return redirect()->route('faculty.results.index')->with('success', 'Results saved successfully!');
    }
}
