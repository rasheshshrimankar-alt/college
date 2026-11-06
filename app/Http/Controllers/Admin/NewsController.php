<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('creator');
        if ($request->search) $query->where('title', 'like', '%' . $request->search . '%');
        $news = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required',
            'content'  => 'required',
            'category' => 'required',
            'status'   => 'required',
        ]);

        $data = $request->only('title', 'content', 'category', 'status')
            + ['created_by' => auth()->id(), 'is_featured' => $request->boolean('is_featured')];

        if ($request->hasFile('image')) {
            $file        = $request->file('image');
            $name        = time() . '.' . $file->extension();
            $file->move(public_path('uploads/news'), $name);
            $data['image'] = $name;
        }

        News::create($data);
        return redirect()->route('admin.news.index')->with('success', 'News published!');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'    => 'required',
            'content'  => 'required',
            'category' => 'required',
        ]);

        $data = $request->only('title', 'content', 'category', 'status')
            + ['is_featured' => $request->boolean('is_featured')];

        if ($request->hasFile('image')) {
            $file        = $request->file('image');
            $name        = time() . '.' . $file->extension();
            $file->move(public_path('uploads/news'), $name);
            $data['image'] = $name;
        }

        $news->update($data);
        return redirect()->route('admin.news.index')->with('success', 'News updated!');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'News deleted!');
    }
}
