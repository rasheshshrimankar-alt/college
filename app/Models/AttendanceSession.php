<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
    protected $fillable = [
        'faculty_id', 'subject_id', 'course_id', 'semester',
        'academic_year', 'token', 'expires_at',
    ];

    protected $casts = ['expires_at' => 'datetime'];

    public function faculty() { return $this->belongsTo(Faculty::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
}
