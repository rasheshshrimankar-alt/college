<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'examination_id', 'subject_id', 'marks_obtained',
        'total_marks', 'percentage', 'grade', 'status', 'remarks', 'faculty_id'
    ];

    protected $casts = [
        'marks_obtained' => 'decimal:2',
        'total_marks'    => 'decimal:2',
        'percentage'     => 'decimal:2',
    ];

    public function student()     { return $this->belongsTo(Student::class); }
    public function examination() { return $this->belongsTo(Examination::class); }
    public function subject()     { return $this->belongsTo(Subject::class); }
    public function faculty()     { return $this->belongsTo(Faculty::class); }

    public function getGradeAttribute($value): string
    {
        if ($value) return $value;
        $pct = $this->percentage ?? ($this->total_marks > 0 ? ($this->marks_obtained / $this->total_marks * 100) : 0);
        return match(true) {
            $pct >= 90 => 'O',
            $pct >= 80 => 'A+',
            $pct >= 70 => 'A',
            $pct >= 60 => 'B+',
            $pct >= 50 => 'B',
            $pct >= 40 => 'C',
            default    => 'F',
        };
    }
}

