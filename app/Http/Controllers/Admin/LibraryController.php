<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LibraryBook;
use App\Models\BookIssue;
use App\Models\Student;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $query = LibraryBook::query();
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');
        }
        if ($request->category) $query->where('category', $request->category);

        $books      = $query->paginate(15)->withQueryString();
        $categories = LibraryBook::select('category')->distinct()->pluck('category');

        return view('admin.library.index', compact('books', 'categories'));
    }

    public function create()
    {
        return view('admin.library.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required',
            'author'       => 'required',
            'total_copies' => 'required|integer|min:1',
        ]);

        LibraryBook::create(
            $request->only('title', 'author', 'isbn', 'publisher', 'publication_year', 'category', 'total_copies', 'location', 'description')
            + ['available_copies' => $request->total_copies, 'status' => 'available']
        );

        return redirect()->route('admin.library.index')->with('success', 'Book added!');
    }

    public function edit(LibraryBook $libraryBook)
    {
        return view('admin.library.edit', compact('libraryBook'));
    }

    public function update(Request $request, LibraryBook $libraryBook)
    {
        $request->validate([
            'title'  => 'required',
            'author' => 'required',
        ]);

        $libraryBook->update(
            $request->only('title', 'author', 'isbn', 'publisher', 'publication_year', 'category', 'total_copies', 'location', 'description', 'status')
        );

        return redirect()->route('admin.library.index')->with('success', 'Book updated!');
    }

    public function destroy(LibraryBook $libraryBook)
    {
        $libraryBook->delete();
        return redirect()->route('admin.library.index')->with('success', 'Book deleted!');
    }

    public function issues(Request $request)
    {
        $issues = BookIssue::with('book', 'student.user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.library.issues', compact('issues'));
    }

    public function issueBook(Request $request)
    {
        $request->validate([
            'library_book_id' => 'required',
            'student_id'      => 'required',
            'due_date'        => 'required|date|after:today',
        ]);

        $book = LibraryBook::findOrFail($request->library_book_id);

        if ($book->available_copies < 1) {
            return back()->with('error', 'No copies available!');
        }

        BookIssue::create([
            'library_book_id' => $request->library_book_id,
            'student_id'      => $request->student_id,
            'issue_date'      => today(),
            'due_date'        => $request->due_date,
            'status'          => 'issued',
        ]);

        $book->decrement('available_copies');

        return redirect()->route('admin.library.issues')->with('success', 'Book issued!');
    }

    public function returnBook(BookIssue $bookIssue)
    {
        $bookIssue->update([
            'return_date' => today(),
            'status'      => 'returned',
        ]);
        $bookIssue->book->increment('available_copies');
        return back()->with('success', 'Book returned!');
    }
}
