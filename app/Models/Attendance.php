<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'subject_id', 'faculty_id', 'date', 'status', 'academic_year', 'semester', 'remarks'
    ];

    protected $casts = ['date' => 'date'];

    public function student() { return $this->belongsTo(Student::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
    public function faculty() { return $this->belongsTo(Faculty::class); }
}

