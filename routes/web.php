<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\StudentController as AdminStudent;
use App\Http\Controllers\Admin\FacultyController as AdminFaculty;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartment;
use App\Http\Controllers\Admin\CourseController as AdminCourse;
use App\Http\Controllers\Admin\AdmissionController as AdminAdmission;
use App\Http\Controllers\Admin\NoticeController as AdminNotice;
use App\Http\Controllers\Admin\NewsController as AdminNews;
use App\Http\Controllers\Admin\EventController as AdminEvent;
use App\Http\Controllers\Admin\GalleryController as AdminGallery;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaint;
use App\Http\Controllers\Admin\FeeController as AdminFee;
use App\Http\Controllers\Admin\LibraryController as AdminLibrary;
use App\Http\Controllers\Admin\ScholarshipController as AdminScholarship;
use App\Http\Controllers\Admin\PlacementController as AdminPlacement;
use App\Http\Controllers\Admin\ExaminationController as AdminExamination;
use App\Http\Controllers\Admin\ResultController as AdminResult;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendance;
use App\Http\Controllers\Admin\ReportController as AdminReport;
use App\Http\Controllers\Admin\SettingController as AdminSetting;
use App\Http\Controllers\Faculty\DashboardController as FacultyDashboard;
use App\Http\Controllers\Faculty\AttendanceController as FacultyAttendance;
use App\Http\Controllers\Faculty\ResultController as FacultyResult;
use App\Http\Controllers\Faculty\AssignmentController as FacultyAssignment;
use App\Http\Controllers\Faculty\MaterialController as FacultyMaterial;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Student\AttendanceController as StudentAttendance;
use App\Http\Controllers\Student\ResultController as StudentResult;
use App\Http\Controllers\Student\ComplaintController as StudentComplaint;
use App\Http\Controllers\Student\FeeController as StudentFee;

// ── Public ──────────────────────────────────────────────────────────────────
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/principal', [PublicController::class, 'principal'])->name('principal');
Route::get('/vision-mission', [PublicController::class, 'visionMission'])->name('vision-mission');
Route::get('/departments', [PublicController::class, 'departments'])->name('departments');
Route::get('/courses', [PublicController::class, 'courses'])->name('courses');
Route::get('/faculty', [PublicController::class, 'faculty'])->name('faculty');
Route::get('/admissions', [PublicController::class, 'admissions'])->name('admissions');
Route::post('/admissions/apply', [PublicController::class, 'submitAdmission'])->name('admissions.apply');
Route::get('/notices', [PublicController::class, 'notices'])->name('notices');
Route::get('/news', [PublicController::class, 'news'])->name('news');
Route::get('/events', [PublicController::class, 'events'])->name('events');
Route::get('/gallery', [PublicController::class, 'gallery'])->name('gallery');
Route::get('/facilities', [PublicController::class, 'facilities'])->name('facilities');
Route::get('/library', [PublicController::class, 'library'])->name('library');
Route::get('/scholarships', [PublicController::class, 'scholarships'])->name('scholarships');
Route::get('/placements', [PublicController::class, 'placements'])->name('placements');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [PublicController::class, 'submitContact'])->name('contact.submit');

// ── Auth ─────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ── Admin ─────────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('students', AdminStudent::class);
    Route::resource('faculty', AdminFaculty::class);
    Route::resource('departments', AdminDepartment::class);
    Route::resource('courses', AdminCourse::class);
    Route::get('/admissions', [AdminAdmission::class, 'index'])->name('admissions.index');
    Route::get('/admissions/{admission}', [AdminAdmission::class, 'show'])->name('admissions.show');
    Route::patch('/admissions/{admission}/status', [AdminAdmission::class, 'updateStatus'])->name('admissions.updateStatus');
    Route::resource('notices', AdminNotice::class);
    Route::resource('news', AdminNews::class);
    Route::resource('events', AdminEvent::class);
    Route::get('/gallery', [AdminGallery::class, 'index'])->name('gallery.index');
    Route::get('/gallery/create', [AdminGallery::class, 'create'])->name('gallery.create');
    Route::post('/gallery', [AdminGallery::class, 'store'])->name('gallery.store');
    Route::delete('/gallery/{gallery}', [AdminGallery::class, 'destroy'])->name('gallery.destroy');
    Route::get('/complaints', [AdminComplaint::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{complaint}', [AdminComplaint::class, 'show'])->name('complaints.show');
    Route::post('/complaints/{complaint}/respond', [AdminComplaint::class, 'respond'])->name('complaints.respond');
    Route::get('/fees', [AdminFee::class, 'index'])->name('fees.index');
    Route::get('/fees/structure', [AdminFee::class, 'feeStructure'])->name('fees.structure');
    Route::post('/fees/structure', [AdminFee::class, 'storeFeeStructure'])->name('fees.structure.store');
    Route::get('/fees/report', [AdminFee::class, 'report'])->name('fees.report');
    Route::resource('library', AdminLibrary::class);
    Route::get('/library/issues', [AdminLibrary::class, 'issues'])->name('library.issues');
    Route::post('/library/issue-book', [AdminLibrary::class, 'issueBook'])->name('library.issue-book');
    Route::patch('/library/return/{bookIssue}', [AdminLibrary::class, 'returnBook'])->name('library.return');
    Route::resource('scholarships', AdminScholarship::class);
    Route::get('/placements', [AdminPlacement::class, 'index'])->name('placements.index');
    Route::get('/placements/create', [AdminPlacement::class, 'create'])->name('placements.create');
    Route::post('/placements', [AdminPlacement::class, 'store'])->name('placements.store');
    Route::delete('/placements/{placement}', [AdminPlacement::class, 'destroy'])->name('placements.destroy');
    Route::resource('examinations', AdminExamination::class);
    Route::get('/examinations/{examination}/results', [AdminExamination::class, 'results'])->name('examinations.results');
    Route::get('/results', [AdminResult::class, 'index'])->name('results.index');
    Route::get('/results/create', [AdminResult::class, 'create'])->name('results.create');
    Route::post('/results', [AdminResult::class, 'store'])->name('results.store');
    Route::delete('/results/{result}', [AdminResult::class, 'destroy'])->name('results.destroy');
    Route::get('/attendance', [AdminAttendance::class, 'index'])->name('attendance.index');
    Route::get('/attendance/report', [AdminAttendance::class, 'report'])->name('attendance.report');
    Route::get('/reports', [AdminReport::class, 'index'])->name('reports.index');
    Route::get('/settings', [AdminSetting::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSetting::class, 'update'])->name('settings.update');
});

// ── Faculty ───────────────────────────────────────────────────────────────────
Route::prefix('faculty')->name('faculty.')->middleware(['auth', 'faculty'])->group(function () {
    Route::get('/dashboard', [FacultyDashboard::class, 'index'])->name('dashboard');
    Route::get('/profile', [FacultyDashboard::class, 'profile'])->name('profile');
    Route::patch('/profile', [FacultyDashboard::class, 'updateProfile'])->name('profile.update');
    Route::get('/students', [FacultyDashboard::class, 'students'])->name('students');
    Route::get('/notices', [FacultyDashboard::class, 'notices'])->name('notices');
    Route::get('/complaints', [FacultyDashboard::class, 'complaints'])->name('complaints');
    Route::get('/salary', [FacultyDashboard::class, 'salary'])->name('salary');
    Route::get('/attendance', [FacultyAttendance::class, 'index'])->name('attendance.index');
    Route::get('/attendance/take', [FacultyAttendance::class, 'markForm'])->name('attendance.take');
    Route::get('/attendance/mark', [FacultyAttendance::class, 'markForm'])->name('attendance.mark');
    Route::post('/attendance/mark', [FacultyAttendance::class, 'markStore'])->name('attendance.mark.store');
    Route::get('/attendance/report', [FacultyAttendance::class, 'report'])->name('attendance.report');
    Route::get('/results', [FacultyResult::class, 'index'])->name('results.index');
    Route::get('/results/create', [FacultyResult::class, 'create'])->name('results.create');
    Route::post('/results', [FacultyResult::class, 'store'])->name('results.store');
    Route::get('/assignments', [FacultyAssignment::class, 'index'])->name('assignments.index');
    Route::get('/assignments/create', [FacultyAssignment::class, 'create'])->name('assignments.create');
    Route::post('/assignments', [FacultyAssignment::class, 'store'])->name('assignments.store');
    Route::get('/assignments/{assignment}/edit', [FacultyAssignment::class, 'edit'])->name('assignments.edit');
    Route::patch('/assignments/{assignment}', [FacultyAssignment::class, 'update'])->name('assignments.update');
    Route::delete('/assignments/{assignment}', [FacultyAssignment::class, 'destroy'])->name('assignments.destroy');
    Route::get('/materials', [FacultyMaterial::class, 'index'])->name('materials.index');
    Route::get('/materials/create', [FacultyMaterial::class, 'create'])->name('materials.create');
    Route::post('/materials', [FacultyMaterial::class, 'store'])->name('materials.store');
    Route::delete('/materials/{material}', [FacultyMaterial::class, 'destroy'])->name('materials.destroy');
});

// ── Student ───────────────────────────────────────────────────────────────────
Route::prefix('student')->name('student.')->middleware(['auth', 'student'])->group(function () {
    Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('dashboard');
    Route::get('/profile', [StudentDashboard::class, 'profile'])->name('profile');
    Route::patch('/profile', [StudentDashboard::class, 'updateProfile'])->name('profile.update');
    Route::get('/results', [StudentResult::class, 'index'])->name('results.index');
    Route::get('/attendance', [StudentAttendance::class, 'index'])->name('attendance.index');
    Route::get('/fees', [StudentFee::class, 'index'])->name('fees.index');
    Route::get('/complaints', [StudentComplaint::class, 'index'])->name('complaints.index');
    Route::get('/complaints/create', [StudentComplaint::class, 'create'])->name('complaints.create');
    Route::post('/complaints', [StudentComplaint::class, 'store'])->name('complaints.store');
    Route::get('/complaints/{complaint}', [StudentComplaint::class, 'show'])->name('complaints.show');
    Route::get('/assignments', [StudentDashboard::class, 'assignments'])->name('assignments');
    Route::get('/materials', [StudentDashboard::class, 'materials'])->name('materials');
    Route::get('/notices', [StudentDashboard::class, 'notices'])->name('notices');
    Route::get('/library', [StudentDashboard::class, 'library'])->name('library');
    Route::get('/scholarship', [StudentDashboard::class, 'scholarship'])->name('scholarship');
    Route::get('/timetable', [StudentDashboard::class, 'timetable'])->name('timetable');
});
