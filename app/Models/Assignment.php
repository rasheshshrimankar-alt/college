<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id', 'course_id', 'department_id', 'faculty_id',
        'title', 'description', 'due_date', 'max_marks', 'total_marks',
        'file_path', 'semester', 'academic_year', 'status'
    ];

    protected $casts = ['due_date' => 'date'];

    public function subject()      { return $this->belongsTo(Subject::class); }
    public function faculty()      { return $this->belongsTo(Faculty::class); }
    public function course()       { return $this->belongsTo(Course::class); }
    public function department()   { return $this->belongsTo(Department::class); }
    public function submissions()  { return $this->hasMany(AssignmentSubmission::class); }
}
