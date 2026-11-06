<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    public function index()
    {
        $scholarships = Scholarship::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.scholarships.index', compact('scholarships'));
    }

    public function create()
    {
        return view('admin.scholarships.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'description' => 'required',
            'provider'    => 'required',
            'eligibility' => 'required',
        ]);

        Scholarship::create(
            $request->only('name', 'description', 'provider', 'amount', 'eligibility', 'application_deadline', 'apply_link')
            + ['status' => 'active']
        );

        return redirect()->route('admin.scholarships.index')->with('success', 'Scholarship added!');
    }

    public function edit(Scholarship $scholarship)
    {
        return view('admin.scholarships.edit', compact('scholarship'));
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        $request->validate([
            'name'        => 'required',
            'description' => 'required',
        ]);

        $scholarship->update(
            $request->only('name', 'description', 'provider', 'amount', 'eligibility', 'application_deadline', 'apply_link', 'status')
        );

        return redirect()->route('admin.scholarships.index')->with('success', 'Scholarship updated!');
    }

    public function destroy(Scholarship $scholarship)
    {
        $scholarship->delete();
        return redirect()->route('admin.scholarships.index')->with('success', 'Scholarship deleted!');
    }
}
