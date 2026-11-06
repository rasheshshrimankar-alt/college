<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentSubmission extends Model
{
    use HasFactory;
    protected $table = 'assignment_submissions';
    protected $fillable = [
        'assignment_id', 'student_id', 'file_path', 'remarks', 'marks_obtained', 'status', 'submitted_at'
    ];
    protected $casts = ['submitted_at' => 'datetime', 'marks_obtained' => 'decimal:2'];
    public function assignment() { return $this->belongsTo(Assignment::class); }
    public function student()    { return $this->belongsTo(Student::class); }
}
