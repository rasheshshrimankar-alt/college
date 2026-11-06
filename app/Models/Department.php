<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'description', 'head_name', 'image', 'established_year', 'status'
    ];

    public function courses()   { return $this->hasMany(Course::class); }
    public function faculty()   { return $this->hasMany(Faculty::class); }
    public function students()  { return $this->hasMany(Student::class); }
    public function subjects()  { return $this->hasMany(Subject::class); }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('uploads/departments/' . $this->image))) {
            return asset('uploads/departments/' . $this->image);
        }
        return asset('images/dept-default.jpg');
    }
}
