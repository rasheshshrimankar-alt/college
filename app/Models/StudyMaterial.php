<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudyMaterial extends Model
{
    use HasFactory;

    protected $table = 'study_materials';

    protected $fillable = [
        'subject_id', 'course_id', 'department_id', 'faculty_id',
        'title', 'description', 'file_path', 'file_url', 'type',
        'file_type', 'file_size', 'semester', 'academic_year',
        'download_count', 'status'
    ];

    public function subject()    { return $this->belongsTo(Subject::class); }
    public function faculty()    { return $this->belongsTo(Faculty::class); }
    public function course()     { return $this->belongsTo(Course::class); }
    public function department() { return $this->belongsTo(Department::class); }
}
