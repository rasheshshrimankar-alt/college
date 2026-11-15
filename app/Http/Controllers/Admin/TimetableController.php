<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Subject;
use App\Models\TimetableEntry;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $entries = TimetableEntry::with(['course', 'subject', 'faculty.user'])
            ->orderBy('day_of_week')->orderBy('start_time')->paginate(20);
        $courses = Course::where('status', 'active')->orderBy('name')->get();
        $subjects = Subject::where('status', 'active')->orderBy('name')->get();
        $faculty = Faculty::with('user')->where('status', 'active')->get();

        return view('admin.timetable.index', compact('entries', 'courses', 'subjects', 'faculty'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
            'faculty_id' => 'required|exists:faculty,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:60',
            'semester' => 'required|integer|min:1|max:12',
            'academic_year' => 'required|string|max:20',
        ]);

        $subject = Subject::findOrFail($validated['subject_id']);
        abort_unless(
            (int) $subject->course_id === (int) $validated['course_id']
            && (int) $subject->semester === (int) $validated['semester'],
            422,
            'The selected subject does not match this course and semester.'
        );

        $assigned = Faculty::findOrFail($validated['faculty_id'])
            ->subjects()->where('subjects.id', $subject->id)->exists();
        abort_unless($assigned, 422, 'The selected faculty member is not assigned to this subject.');

        $overlap = TimetableEntry::where('course_id', $validated['course_id'])
            ->where('semester', $validated['semester'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('start_time', '<', $validated['end_time'])
            ->where('end_time', '>', $validated['start_time'])
            ->exists();
        if ($overlap) {
            return back()->withInput()->withErrors(['start_time' => 'This class overlaps another class for the selected course and semester.']);
        }

        TimetableEntry::create($validated);

        return back()->with('success', 'Timetable entry published.');
    }

    public function destroy(TimetableEntry $entry)
    {
        $entry->delete();
        return back()->with('success', 'Timetable entry removed.');
    }
}
