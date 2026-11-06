<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Course;
use App\Models\Department;
use App\Models\Admission;
use App\Models\FeePayment;
use App\Models\Notice;
use App\Models\Event;
use App\Models\Complaint;
use App\Models\Examination;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'students'           => Student::where('status', 'active')->count(),
            'faculty'            => Faculty::where('status', 'active')->count(),
            'courses'            => Course::where('status', 'active')->count(),
            'departments'        => Department::where('status', 'active')->count(),
            'admissions'         => Admission::count(),
            'pending_admissions' => Admission::where('status', 'pending')->count(),
            'total_revenue'      => FeePayment::where('status', 'paid')->sum('amount_paid'),
            'pending_fees'       => Student::sum('fees_due'),
            'open_complaints'    => Complaint::where('status', 'open')->count(),
            'upcoming_exams'     => Examination::where('status', 'upcoming')->count(),
        ];

        $recentAdmissions  = Admission::with('course', 'department')
            ->orderBy('created_at', 'desc')->take(5)->get();

        $recentFeePayments = FeePayment::with('student.user')
            ->orderBy('created_at', 'desc')->take(5)->get();

        $upcomingEvents    = Event::where('status', 'upcoming')
            ->orderBy('start_datetime')->take(4)->get();

        $monthlyRevenue    = FeePayment::where('status', 'paid')
            ->selectRaw('MONTH(payment_date) as month, SUM(amount_paid) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $admissionByDept   = Admission::with('department')
            ->selectRaw('department_id, COUNT(*) as count')
            ->groupBy('department_id')
            ->get();

        $recentComplaints  = Complaint::with('user')
            ->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'recentAdmissions', 'recentFeePayments',
            'upcomingEvents', 'monthlyRevenue', 'admissionByDept', 'recentComplaints'
        ));
    }
}
