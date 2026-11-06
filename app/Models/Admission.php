<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'department_id', 'student_id', 'application_number',
        'applicant_name', 'applicant_email', 'applicant_phone', 'date_of_birth',
        'gender', 'address', 'previous_qualification', 'previous_percentage',
        'guardian_name', 'guardian_phone', 'documents', 'status', 'academic_year', 'remarks'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'previous_percentage' => 'decimal:2',
    ];

    public function course()     { return $this->belongsTo(Course::class); }
    public function department() { return $this->belongsTo(Department::class); }
    public function student()    { return $this->belongsTo(Student::class); }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'approved'   => '<span class="badge bg-success">Approved</span>',
            'rejected'   => '<span class="badge bg-danger">Rejected</span>',
            'waitlisted' => '<span class="badge bg-warning text-dark">Waitlisted</span>',
            default      => '<span class="badge bg-secondary">Pending</span>',
        };
    }
}
