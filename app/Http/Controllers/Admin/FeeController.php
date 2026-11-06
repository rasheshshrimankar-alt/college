<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index(Request $request)
    {
        $query = FeePayment::with('student.user', 'fee');
        if ($request->search) {
            $query->whereHas('student.user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        $payments = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $stats = [
            'total_collected' => FeePayment::where('status', 'paid')->sum('amount_paid'),
            'total_pending'   => Student::sum('fees_due'),
            'paid_students'   => FeePayment::where('status', 'paid')->distinct('student_id')->count('student_id'),
            'defaulters'      => Student::where('fees_due', '>', 0)->count(),
        ];

        return view('admin.fees.index', compact('payments', 'stats'));
    }

    public function feeStructure()
    {
        $fees    = Fee::with('course')->orderBy('created_at', 'desc')->paginate(10);
        $courses = Course::where('status', 'active')->get();
        return view('admin.fees.structure', compact('fees', 'courses'));
    }

    public function storeFeeStructure(Request $request)
    {
        $request->validate([
            'course_id'     => 'required',
            'fee_type'      => 'required',
            'amount'        => 'required|numeric',
            'academic_year' => 'required',
            'semester'      => 'required|integer',
        ]);

        Fee::create(
            $request->only('course_id', 'fee_type', 'amount', 'academic_year', 'semester', 'due_date', 'description')
            + ['status' => 'active']
        );

        return redirect()->route('admin.fees.structure')->with('success', 'Fee structure added!');
    }

    public function report()
    {
        $students = Student::with('user', 'course', 'feePayments')->paginate(15);
        return view('admin.fees.report', compact('students'));
    }
}
