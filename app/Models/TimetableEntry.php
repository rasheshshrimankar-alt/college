<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimetableEntry extends Model
{
    protected $fillable = [
        'course_id', 'subject_id', 'faculty_id', 'day_of_week',
        'start_time', 'end_time', 'room', 'semester', 'academic_year',
    ];

    public function course() { return $this->belongsTo(Course::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
    public function faculty() { return $this->belongsTo(Faculty::class); }
}
