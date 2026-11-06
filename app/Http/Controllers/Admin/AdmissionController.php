<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Admission::with('course', 'department');

        if ($request->search) {
            $query->where('applicant_name', 'like', '%' . $request->search . '%')
                  ->orWhere('application_number', 'like', '%' . $request->search . '%');
        }
        if ($request->status)     $query->where('status', $request->status);
        if ($request->department) $query->where('department_id', $request->department);

        $admissions  = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $departments = Department::get();

        $stats = [
            'total'    => Admission::count(),
            'pending'  => Admission::where('status', 'pending')->count(),
            'approved' => Admission::where('status', 'approved')->count(),
            'rejected' => Admission::where('status', 'rejected')->count(),
        ];

        return view('admin.admissions.index', compact('admissions', 'departments', 'stats'));
    }

    public function show(Admission $admission)
    {
        return view('admin.admissions.show', compact('admission'));
    }

    public function updateStatus(Request $request, Admission $admission)
    {
        $request->validate([
            'status'  => 'required|in:pending,approved,rejected,waitlisted',
            'remarks' => 'nullable',
        ]);

        $admission->update([
            'status'  => $request->status,
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', 'Admission status updated!');
    }
}
