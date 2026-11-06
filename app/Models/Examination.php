<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Examination extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'department_id', 'name', 'exam_type', 'semester',
        'academic_year', 'start_date', 'end_date', 'total_marks', 'passing_marks', 'status', 'description'
    ];

    protected $casts = ['start_date' => 'date', 'end_date' => 'date'];

    public function course()     { return $this->belongsTo(Course::class); }
    public function department() { return $this->belongsTo(Department::class); }
    public function results()    { return $this->hasMany(Result::class); }
}

