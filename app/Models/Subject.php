<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'department_id', 'name', 'code', 'semester', 'credits', 'type', 'status'
    ];

    public function course()      { return $this->belongsTo(Course::class); }
    public function department()  { return $this->belongsTo(Department::class); }
    public function faculty()     { return $this->belongsToMany(Faculty::class, 'subject_faculty')->withPivot('academic_year', 'semester')->withTimestamps(); }
    public function attendance()  { return $this->hasMany(Attendance::class); }
    public function results()     { return $this->hasMany(Result::class); }
    public function assignments() { return $this->hasMany(Assignment::class); }
    public function studyMaterials(){ return $this->hasMany(StudyMaterial::class); }
}

