<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        $user  = auth()->user();
        $stats = [
            'students'    => Student::count(),
            'faculty'     => Faculty::count(),
            'courses'     => Course::count(),
            'departments' => Department::count(),
        ];
        return view('admin.settings.index', compact('user', 'stats'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        $user = auth()->user();

        $data = ['name' => $request->name, 'email' => $request->email, 'phone' => $request->phone];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Settings updated successfully!');
    }
}
