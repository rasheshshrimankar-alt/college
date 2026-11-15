<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Department;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

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

        try {
            // Keep user and student creation atomic so a failed student insert cannot
            // leave behind an account that causes a duplicate-email error on retry.
            $user = DB::transaction(function () use ($request) {
                $course = Course::with('department')->findOrFail($request->course_id);

                $user = User::create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'phone'    => $request->phone,
                    'role'     => 'student',
                    'password' => Hash::make($request->password),
                    'status'   => 'active',
                ]);

                $year = date('Y');
                $uniqueSuffix = str_pad((string) $user->id, 6, '0', STR_PAD_LEFT);

                Student::create([
                    'user_id'       => $user->id,
                    'course_id'     => $course->id,
                    'department_id' => $course->department_id,
                    'student_id'    => 'STU' . $year . $uniqueSuffix,
                    'roll_number'   => $year . $uniqueSuffix,
                    'batch_year'    => $year . '-' . substr((string) ($year + 1), -2),
                    'status'        => 'active',
                ]);

                return $user;
            });
        } catch (QueryException $exception) {
            // Handle a duplicate email safely if two registration requests arrive together.
            if (in_array((string) $exception->getCode(), ['23000', '23505'], true)) {
                return back()
                    ->withErrors(['email' => 'This email address is already registered. Please log in instead.'])
                    ->withInput($request->except('password', 'password_confirmation'));
            }

            throw $exception;
        }

        FormSubmission::create([
            'form_type' => 'Registration',
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'payload' => ['course_id' => $request->input('course_id')],
        ]);

        Auth::login($user);
        return redirect()->route('student.dashboard')
            ->with('success', 'Registration successful! Welcome to SMART CAMPUS.');
    }
}
