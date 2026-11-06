<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::withCount(['courses', 'faculty', 'students']);
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $departments = $query->paginate(10)->withQueryString();
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|unique:departments',
            'code'             => 'required|unique:departments',
            'description'      => 'nullable',
            'head_name'        => 'nullable',
            'established_year' => 'nullable|integer',
        ]);

        Department::create(
            $request->only('name', 'code', 'description', 'head_name', 'established_year')
            + ['status' => 'active']
        );

        return redirect()->route('admin.departments.index')->with('success', 'Department created!');
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|unique:departments,name,' . $department->id,
            'code' => 'required|unique:departments,code,' . $department->id,
        ]);

        $department->update(
            $request->only('name', 'code', 'description', 'head_name', 'established_year', 'status')
        );

        return redirect()->route('admin.departments.index')->with('success', 'Department updated!');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Department deleted!');
    }
}
