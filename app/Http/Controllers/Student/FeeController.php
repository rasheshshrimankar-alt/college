<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\FeePayment;
use App\Models\Fee;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $student  = auth()->user()->student;
        $payments = FeePayment::where('student_id', $student->id)
            ->with('fee')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $fees = Fee::where('course_id', $student->course_id)
            ->where('status', 'active')
            ->get();

        $stats = [
            'total_paid' => FeePayment::where('student_id', $student->id)->where('status', 'paid')->sum('amount_paid'),
            'fees_due'   => $student->fees_due ?? 0,
        ];

        return view('student.fees', compact('payments', 'fees', 'stats'));
    }
}
