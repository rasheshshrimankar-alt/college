<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('user', 'course', 'department');

        if ($request->search) {
            $query->whereHas('user', fn($q) => $q
                ->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
            );
        }
        if ($request->department) $query->where('department_id', $request->department);
        if ($request->course)     $query->where('course_id', $request->course);
        if ($request->status)     $query->where('status', $request->status);

        $students    = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $departments = Department::where('status', 'active')->get();
        $courses     = Course::where('status', 'active')->get();

        return view('admin.students.index', compact('students', 'departments', 'courses'));
    }

    public function create()
    {
        $courses     = Course::where('status', 'active')->with('department')->get();
        $departments = Department::where('status', 'active')->get();
        return view('admin.students.create', compact('courses', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required',
            'email'      => 'required|email|unique:users',
            'phone'      => 'required',
            'course_id'  => 'required|exists:courses,id',
            'password'   => 'required|min:8',
            'gender'     => 'required',
            'batch_year' => 'required',
        ]);

        $course = Course::findOrFail($request->course_id);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'role'     => 'student',
            'password' => Hash::make($request->password),
            'status'   => 'active',
        ]);

        Student::create([
            'user_id'        => $user->id,
            'course_id'      => $course->id,
            'department_id'  => $course->department_id,
            'student_id'     => 'STU' . str_pad(Student::count(), 4, '0', STR_PAD_LEFT),
            'roll_number'    => date('Y') . str_pad(Student::count(), 4, '0', STR_PAD_LEFT),
            'batch_year'     => $request->batch_year,
            'gender'         => $request->gender,
            'phone'          => $request->phone,
            'guardian_name'  => $request->guardian_name,
            'guardian_phone' => $request->guardian_phone,
            'blood_group'    => $request->blood_group,
            'status'         => 'active',
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student added successfully!');
    }

    public function show(Student $student)
    {
        $student->load('user', 'course', 'department', 'results.subject', 'attendance', 'feePayments', 'bookIssues.book', 'placements');
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $courses     = Course::where('status', 'active')->with('department')->get();
        $departments = Department::where('status', 'active')->get();
        return view('admin.students.edit', compact('student', 'courses', 'departments'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email,' . $student->user_id,
            'phone'     => 'required',
            'course_id' => 'required',
        ]);

        $student->user->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'status' => $request->status,
        ]);

        $course = Course::findOrFail($request->course_id);

        $student->update([
            'course_id'        => $request->course_id,
            'department_id'    => $course->department_id,
            'current_semester' => $request->current_semester,
            'batch_year'       => $request->batch_year,
            'gender'           => $request->gender,
            'phone'            => $request->phone,
            'guardian_name'    => $request->guardian_name,
            'guardian_phone'   => $request->guardian_phone,
            'blood_group'      => $request->blood_group,
            'address'          => $request->address,
            'status'           => $request->status,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        $student->user->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted!');
    }
}
