<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Placement;
use App\Models\Student;
use Illuminate\Http\Request;

class PlacementController extends Controller
{
    public function index(Request $request)
    {
        $query = Placement::with('student.user', 'student.course');
        if ($request->search)        $query->where('company_name', 'like', '%' . $request->search . '%');
        if ($request->academic_year) $query->where('academic_year', $request->academic_year);

        $placements = $query->orderBy('package_lpa', 'desc')->paginate(15)->withQueryString();

        $stats = [
            'total'       => Placement::count(),
            'avg_package' => round(Placement::avg('package_lpa'), 2),
            'max_package' => Placement::max('package_lpa'),
            'companies'   => Placement::distinct('company_name')->count(),
        ];

        return view('admin.placements.index', compact('placements', 'stats'));
    }

    public function create()
    {
        $students = Student::with('user')->where('status', 'active')->get();
        return view('admin.placements.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id'    => 'required',
            'company_name'  => 'required',
            'position'      => 'required',
            'academic_year' => 'required',
        ]);

        Placement::create(
            $request->only('student_id', 'company_name', 'position', 'package_lpa', 'placement_type', 'academic_year', 'offer_date', 'status')
        );

        return redirect()->route('admin.placements.index')->with('success', 'Placement added!');
    }

    public function destroy(Placement $placement)
    {
        $placement->delete();
        return redirect()->route('admin.placements.index')->with('success', 'Placement record deleted!');
    }
}
