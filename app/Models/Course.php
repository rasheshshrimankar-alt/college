<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id', 'name', 'code', 'description', 'duration_years',
        'total_semesters', 'fees_per_semester', 'total_seats', 'image', 'status'
    ];

    public function department()  { return $this->belongsTo(Department::class); }
    public function students()    { return $this->hasMany(Student::class); }
    public function subjects()    { return $this->hasMany(Subject::class); }
    public function admissions()  { return $this->hasMany(Admission::class); }
    public function fees()        { return $this->hasMany(Fee::class); }
    public function examinations(){ return $this->hasMany(Examination::class); }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('uploads/courses/' . $this->image))) {
            return asset('uploads/courses/' . $this->image);
        }
        return asset('images/course-default.jpg');
    }
}
