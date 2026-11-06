<?php
namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\StudyMaterial;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $faculty   = auth()->user()->faculty;
        $materials = StudyMaterial::where('faculty_id', $faculty->id)
            ->with('subject', 'course')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('faculty.materials.index', compact('materials', 'faculty'));
    }

    public function create()
    {
        $faculty  = auth()->user()->faculty;
        $subjects = Subject::where('department_id', $faculty->department_id)->get();
        $courses  = Course::where('department_id', $faculty->department_id)->where('status', 'active')->get();
        return view('faculty.materials.create', compact('subjects', 'courses', 'faculty'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required',
            'subject_id'=> 'required|exists:subjects,id',
            'type'      => 'required',
        ]);

        $faculty = auth()->user()->faculty;
        $filePath = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/materials'), $fileName);
            $filePath = $fileName;
        }

        StudyMaterial::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'subject_id'    => $request->subject_id,
            'course_id'     => $request->course_id ?? null,
            'department_id' => $faculty->department_id,
            'faculty_id'    => $faculty->id,
            'type'          => $request->type,
            'file_path'     => $filePath,
            'file_url'      => $request->file_url,
            'semester'      => $request->semester ?? 1,
            'status'        => 'active',
        ]);

        return redirect()->route('faculty.materials.index')->with('success', 'Material uploaded successfully!');
    }

    public function destroy(StudyMaterial $material)
    {
        if ($material->file_path && file_exists(public_path('uploads/materials/' . $material->file_path))) {
            unlink(public_path('uploads/materials/' . $material->file_path));
        }
        $material->delete();
        return redirect()->route('faculty.materials.index')->with('success', 'Material deleted!');
    }
}
