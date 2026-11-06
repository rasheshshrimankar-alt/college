<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Examination;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $student = auth()->user()->student;
        $query   = Result::where('student_id', $student->id)
            ->with('examination', 'subject');

        if ($request->examination_id) $query->where('examination_id', $request->examination_id);

        $results      = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $examinations = Examination::where('course_id', $student->course_id)->get();

        return view('student.results', compact('results', 'examinations'));
    }
}
