<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'course_id', 'department_id', 'student_id', 'roll_number',
        'current_semester', 'current_year', 'batch_year', 'phone', 'address',
        'date_of_birth', 'gender', 'guardian_name', 'guardian_phone',
        'guardian_relation', 'profile_photo', 'blood_group', 'category',
        'fees_paid', 'fees_due', 'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'fees_paid'     => 'decimal:2',
        'fees_due'      => 'decimal:2',
    ];

    public function user()         { return $this->belongsTo(User::class); }
    public function course()       { return $this->belongsTo(Course::class); }
    public function department()   { return $this->belongsTo(Department::class); }
    public function attendance()   { return $this->hasMany(Attendance::class); }
    public function results()      { return $this->hasMany(Result::class); }
    public function feePayments()  { return $this->hasMany(FeePayment::class); }
    public function bookIssues()   { return $this->hasMany(BookIssue::class); }
    public function placements()   { return $this->hasMany(Placement::class); }
    public function complaints()   { return $this->hasMany(Complaint::class, 'user_id', 'user_id'); }

    public function getNameAttribute(): string  { return $this->user->name ?? ''; }
    public function getEmailAttribute(): string { return $this->user->email ?? ''; }

    public function getAttendancePercentageAttribute(): float
    {
        $total  = $this->attendance()->count();
        $present = $this->attendance()->where('status', 'present')->count();
        return $total > 0 ? round(($present / $total) * 100, 1) : 0;
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo && file_exists(public_path('uploads/students/' . $this->profile_photo))) {
            return asset('uploads/students/' . $this->profile_photo);
        }
        return $this->user->avatar_url ?? asset('images/avatar-default.jpg');
    }
}
