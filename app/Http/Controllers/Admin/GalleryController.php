<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::query();
        if ($request->category) $query->where('category', $request->category);
        $gallery    = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();
        $categories = Gallery::select('category')->distinct()->pluck('category');
        return view('admin.gallery.index', compact('gallery', 'categories'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required',
            'image'    => 'required|image|max:5120',
            'category' => 'required',
        ]);

        $file = $request->file('image');
        $name = time() . '.' . $file->extension();
        $file->move(public_path('uploads/gallery'), $name);

        Gallery::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image_path'  => $name,
            'category'    => $request->category,
            'is_featured' => $request->boolean('is_featured'),
            'created_by'  => auth()->id(),
            'status'      => 'active',
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Photo added!');
    }

    public function destroy(Gallery $gallery)
    {
        if (file_exists(public_path('uploads/gallery/' . $gallery->image_path))) {
            unlink(public_path('uploads/gallery/' . $gallery->image_path));
        }
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Photo deleted!');
    }
}
