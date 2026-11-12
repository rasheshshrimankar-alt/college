<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $courses = Course::where('status', 'active')->orderBy('name')->get(['id', 'name', 'code']);
        return view('auth.login', compact('courses'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        // If a student selects a course, make sure it matches their enrolled course.
        // Admin and faculty accounts can leave the course field empty.
        if ($request->filled('course_id')) {
            $candidate = User::where('email', $request->email)->first();
            if ($candidate && $candidate->role === 'student') {
                $enrollment = Student::where('user_id', $candidate->id)->value('course_id');
                if ((string) $enrollment !== (string) $request->course_id) {
                    return back()
                        ->withErrors(['course_id' => 'The selected course does not match your student account.'])
                        ->withInput($request->only('email', 'course_id'));
                }
            }
        }

        if (Auth::attempt(
            ['email' => $request->email, 'password' => $request->password, 'status' => 'active'],
            $request->remember
        )) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (in_array($user->role, ['admin', 'super_admin'])) {
                return redirect()->route('admin.dashboard');
            }
            if ($user->role === 'faculty') {
                return redirect()->route('faculty.dashboard');
            }
            return redirect()->route('student.dashboard');
        }

        return back()
            ->withErrors(['email' => 'Invalid credentials or account inactive.'])
            ->withInput($request->only('email', 'course_id'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
