<?php
namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Notice;
use App\Models\News;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Scholarship;
use App\Models\Placement;
use App\Models\Student;
use App\Models\Admission;
use App\Models\LibraryBook;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $departments = Department::where('status', 'active')->take(6)->get();
        $courses     = Course::where('status', 'active')->with('department')->take(6)->get();
        $faculty     = Faculty::where('status', 'active')->with('user', 'department')->take(6)->get();
        $notices     = Notice::where('status', 'active')->orderBy('created_at', 'desc')->take(5)->get();
        $events      = Event::where('status', 'upcoming')->orderBy('start_datetime')->take(4)->get();
        $news        = News::where('status', 'published')->orderBy('created_at', 'desc')->take(3)->get();
        $gallery     = Gallery::where('status', 'active')->where('is_featured', true)->take(6)->get();
        $placements  = Placement::with('student.user')->orderBy('package_lpa', 'desc')->take(6)->get();

        $stats = [
            'students'    => Student::where('status', 'active')->count(),
            'faculty'     => Faculty::where('status', 'active')->count(),
            'courses'     => Course::where('status', 'active')->count(),
            'departments' => Department::where('status', 'active')->count(),
            'placements'  => Placement::count(),
            'avg_package' => Placement::avg('package_lpa'),
        ];

        return view('public.home', compact(
            'departments', 'courses', 'faculty', 'notices',
            'events', 'news', 'gallery', 'placements', 'stats'
        ));
    }

    public function about()
    {
        return view('public.about');
    }

    public function principal()
    {
        return view('public.principal');
    }

    public function visionMission()
    {
        return view('public.vision-mission');
    }

    public function departments()
    {
        $departments = Department::where('status', 'active')
            ->withCount(['courses', 'faculty', 'students'])
            ->get();
        return view('public.departments', compact('departments'));
    }

    public function courses(Request $request)
    {
        $query = Course::where('status', 'active')->with('department');
        if ($request->department) {
            $query->where('department_id', $request->department);
        }
        $courses     = $query->paginate(9);
        $departments = Department::where('status', 'active')->get();
        return view('public.courses', compact('courses', 'departments'));
    }

    public function faculty(Request $request)
    {
        $query = Faculty::where('status', 'active')->with('user', 'department');
        if ($request->department) {
            $query->where('department_id', $request->department);
        }
        $faculty     = $query->paginate(12);
        $departments = Department::where('status', 'active')->get();
        return view('public.faculty', compact('faculty', 'departments'));
    }

    public function admissions()
    {
        $courses = Course::where('status', 'active')->with('department')->get();
        return view('public.admissions', compact('courses'));
    }

    public function notices(Request $request)
    {
        $query = Notice::where('status', 'active');
        if ($request->category) {
            $query->where('category', $request->category);
        }
        $notices = $query->orderBy('is_important', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('public.notices', compact('notices'));
    }

    public function news(Request $request)
    {
        $query = News::where('status', 'published');
        if ($request->category) {
            $query->where('category', $request->category);
        }
        $news = $query->orderBy('created_at', 'desc')->paginate(9);
        return view('public.news', compact('news'));
    }

    public function events(Request $request)
    {
        $query = Event::query();
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $events = $query->orderBy('start_datetime')->paginate(9);
        return view('public.events', compact('events'));
    }

    public function gallery(Request $request)
    {
        $query = Gallery::where('status', 'active');
        if ($request->category) {
            $query->where('category', $request->category);
        }
        $gallery    = $query->orderBy('is_featured', 'desc')->paginate(12);
        $categories = Gallery::where('status', 'active')
            ->select('category')
            ->distinct()
            ->pluck('category');
        return view('public.gallery', compact('gallery', 'categories'));
    }

    public function facilities()
    {
        return view('public.facilities');
    }

    public function library()
    {
        $books = LibraryBook::where('status', 'available')->paginate(12);
        return view('public.library', compact('books'));
    }

    public function scholarships()
    {
        $scholarships = Scholarship::where('status', 'active')->get();
        return view('public.scholarships', compact('scholarships'));
    }

    public function placements()
    {
        $placements = Placement::with('student.user', 'student.course')
            ->orderBy('package_lpa', 'desc')
            ->paginate(12);

        $stats = [
            'total'       => Placement::count(),
            'avg_package' => Placement::avg('package_lpa'),
            'max_package' => Placement::max('package_lpa'),
            'companies'   => Placement::distinct('company_name')->count('company_name'),
        ];

        return view('public.placements', compact('placements', 'stats'));
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email',
            'subject' => 'required',
            'message' => 'required|min:20',
        ]);

        return back()->with('success', 'Thank you! Your message has been sent. We will respond within 24 hours.');
    }

    public function submitAdmission(Request $request)
    {
        $request->validate([
            'applicant_name'         => 'required',
            'applicant_email'        => 'required|email',
            'applicant_phone'        => 'required',
            'course_id'              => 'required|exists:courses,id',
            'previous_qualification' => 'required',
            'previous_percentage'    => 'required|numeric|between:0,100',
        ]);

        $course = Course::findOrFail($request->course_id);

        Admission::create(array_merge(
            $request->only([
                'applicant_name', 'applicant_email', 'applicant_phone',
                'course_id', 'previous_qualification', 'previous_percentage',
                'guardian_name', 'guardian_phone', 'address',
            ]),
            [
                'department_id'      => $course->department_id,
                'application_number' => 'ADM' . date('Y') . str_pad(Admission::count() + 1, 4, '0', STR_PAD_LEFT),
                'academic_year'      => date('Y') . '-' . substr(date('Y') + 1, -2),
                'status'             => 'pending',
            ]
        ));

        return back()->with('success', 'Application submitted successfully! We will contact you within 3-5 business days.');
    }
}
