<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Department;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $total    = Attendance::count();
        $present  = Attendance::whereDate('date', today())->where('status', 'present')->count();
        $avgPct   = $total > 0
            ? round(Attendance::where('status', 'present')->count() / $total * 100, 1)
            : 0;

        $stats = [
            'total_records'   => $total,
            'present_today'   => $present,
            'avg_percentage'  => $avgPct,
        ];

        $deptAttendance = Department::withCount('students')
            ->where('status', 'active')
            ->get()
            ->map(function ($dept) {
                $dept->avg_pct = rand(70, 95); // placeholder – replace with real calc
                return $dept;
            });

        return view('admin.attendance.index', compact('stats', 'deptAttendance'));
    }

    public function report()
    {
        return view('admin.attendance.report');
    }
}
