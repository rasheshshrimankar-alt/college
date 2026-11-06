<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        $query = Notice::with('creator');

        if ($request->search)   $query->where('title', 'like', '%' . $request->search . '%');
        if ($request->category) $query->where('category', $request->category);

        $notices = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('admin.notices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required',
            'content'      => 'required',
            'category'     => 'required',
            'target'       => 'required',
            'publish_date' => 'required|date',
        ]);

        Notice::create(array_merge(
            $request->only('title', 'content', 'category', 'target', 'publish_date', 'expiry_date'),
            [
                'created_by'   => auth()->id(),
                'status'       => 'active',
                'is_important' => $request->boolean('is_important'),
            ]
        ));

        return redirect()->route('admin.notices.index')->with('success', 'Notice published!');
    }

    public function edit(Notice $notice)
    {
        return view('admin.notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        $request->validate([
            'title'        => 'required',
            'content'      => 'required',
            'category'     => 'required',
            'target'       => 'required',
            'publish_date' => 'required|date',
        ]);

        $notice->update(array_merge(
            $request->only('title', 'content', 'category', 'target', 'publish_date', 'expiry_date', 'status'),
            ['is_important' => $request->boolean('is_important')]
        ));

        return redirect()->route('admin.notices.index')->with('success', 'Notice updated!');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();
        return redirect()->route('admin.notices.index')->with('success', 'Notice deleted!');
    }
}
