<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\URL;

class DigitalIdController extends Controller
{
    public function show()
    {
        $student = auth()->user()->student()->with(['user', 'course', 'department'])->firstOrFail();
        abort_unless($student->status === 'active', 403);

        $verificationUrl = URL::signedRoute('student.id.verify', [
            'publicId' => $student->public_id,
        ]);

        return view('student.id-card', compact('student', 'verificationUrl'));
    }

    public function verify(string $publicId)
    {
        $student = Student::with(['user', 'course', 'department'])
            ->where('public_id', $publicId)
            ->firstOrFail();

        return view('student.id-verify', compact('student'));
    }
}
