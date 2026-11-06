<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('student.complaints.index', compact('complaints'));
    }

    public function create()
    {
        return view('student.complaints.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject'     => 'required',
            'description' => 'required|min:20',
            'category'    => 'required',
            'priority'    => 'required|in:low,medium,high',
        ]);

        Complaint::create([
            'user_id'     => auth()->id(),
            'subject'     => $request->subject,
            'description' => $request->description,
            'category'    => $request->category,
            'priority'    => $request->priority,
            'status'      => 'open',
        ]);

        return redirect()->route('student.complaints.index')
            ->with('success', 'Complaint submitted successfully!');
    }

    public function show(Complaint $complaint)
    {
        if ($complaint->user_id !== auth()->id()) abort(403);
        return view('student.complaints.show', compact('complaint'));
    }
}
