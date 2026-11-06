<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        $query = Faculty::with('user', 'department');

        if ($request->search) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        if ($request->department) $query->where('department_id', $request->department);
        if ($request->status)     $query->where('status', $request->status);

        $faculty     = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $departments = Department::where('status', 'active')->get();

        return view('admin.faculty.index', compact('faculty', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('status', 'active')->get();
        return view('admin.faculty.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|email|unique:users',
            'phone'         => 'required',
            'department_id' => 'required|exists:departments,id',
            'designation'   => 'required',
            'qualification' => 'required',
            'password'      => 'required|min:8',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'role'     => 'faculty',
            'password' => Hash::make($request->password),
            'status'   => 'active',
        ]);

        Faculty::create([
            'user_id'        => $user->id,
            'department_id'  => $request->department_id,
            'faculty_id'     => 'FAC' . str_pad(Faculty::count() + 1, 3, '0', STR_PAD_LEFT),
            'designation'    => $request->designation,
            'qualification'  => $request->qualification,
            'specialization' => $request->specialization,
            'experience'     => $request->experience,
            'joining_date'   => $request->joining_date,
            'salary'         => $request->salary,
            'gender'         => $request->gender,
            'status'         => 'active',
        ]);

        return redirect()->route('admin.faculty.index')->with('success', 'Faculty added successfully!');
    }

    public function show(Faculty $faculty)
    {
        $faculty->load('user', 'department', 'subjects');
        return view('admin.faculty.show', compact('faculty'));
    }

    public function edit(Faculty $faculty)
    {
        $departments = Department::where('status', 'active')->get();
        return view('admin.faculty.edit', compact('faculty', 'departments'));
    }

    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|email|unique:users,email,' . $faculty->user_id,
            'department_id' => 'required',
        ]);

        $faculty->user->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'status' => $request->status ?? 'active',
        ]);

        $faculty->update([
            'department_id'  => $request->department_id,
            'designation'    => $request->designation,
            'qualification'  => $request->qualification,
            'specialization' => $request->specialization,
            'experience'     => $request->experience,
            'salary'         => $request->salary,
            'status'         => $request->status ?? 'active',
        ]);

        return redirect()->route('admin.faculty.index')->with('success', 'Faculty updated successfully!');
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->user->delete();
        return redirect()->route('admin.faculty.index')->with('success', 'Faculty deleted!');
    }
}
