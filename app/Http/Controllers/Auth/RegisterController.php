<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $courses = Course::where('status', 'active')->with('department')->get();
        return view('auth.register', compact('courses'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'phone'     => 'required|string|max:20',
            'course_id' => 'required|exists:courses,id',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        $course = Course::with('department')->findOrFail($request->course_id);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'role'     => 'student',
            'password' => Hash::make($request->password),
            'status'   => 'active',
        ]);

        $studentId  = 'STU' . str_pad(Student::count() + 1, 4, '0', STR_PAD_LEFT);
        $rollNumber = date('Y') . str_pad(Student::count() + 1, 4, '0', STR_PAD_LEFT);

        Student::create([
            'user_id'       => $user->id,
            'course_id'     => $course->id,
            'department_id' => $course->department_id,
            'student_id'    => $studentId,
            'roll_number'   => $rollNumber,
            'batch_year'    => date('Y') . '-' . substr(date('Y') + 1, -2),
            'status'        => 'active',
        ]);

        Auth::login($user);
        return redirect()->route('student.dashboard')
            ->with('success', 'Registration successful! Welcome to SMART CAMPUS.');
    }
}
