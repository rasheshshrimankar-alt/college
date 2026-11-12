<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Admission;
use App\Models\FeePayment;
use App\Models\Placement;
use App\Models\Result;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'students'   => Student::where('status', 'active')->count(),
            'faculty'    => Faculty::where('status', 'active')->count(),
            'placements' => Placement::count(),
            'revenue'    => FeePayment::where('status', 'paid')->sum('amount_paid'),
        ];

        // Use database-specific month extraction: PostgreSQL does not support MySQL's MONTH() function.
        $monthExpression = DB::connection()->getDriverName() === 'pgsql'
            ? 'EXTRACT(MONTH FROM payment_date)::integer'
            : 'MONTH(payment_date)';

        $monthlyRevenue = FeePayment::where('status', 'paid')
            ->selectRaw("$monthExpression as month, SUM(amount_paid) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $admissionStats = [
            'approved'  => Admission::where('status', 'approved')->count(),
            'pending'   => Admission::where('status', 'pending')->count(),
            'rejected'  => Admission::where('status', 'rejected')->count(),
            'total'     => Admission::count(),
        ];

        $deptStats = Department::withCount(['students', 'faculty'])
            ->where('status', 'active')->get();

        $placementStats = [
            'avg'      => round(Placement::avg('package_lpa') ?? 0, 1),
            'max'      => Placement::max('package_lpa') ?? 0,
            'count'    => Placement::count(),
            'companies'=> Placement::distinct('company_name')->count('company_name'),
        ];

        return view('admin.reports.index', compact(
            'stats', 'monthlyRevenue', 'admissionStats', 'deptStats', 'placementStats'
        ));
    }
}
