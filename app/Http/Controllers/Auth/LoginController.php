<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

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
            ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
