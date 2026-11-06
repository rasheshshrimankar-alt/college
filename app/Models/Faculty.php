<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculty';

    protected $fillable = [
        'user_id', 'department_id', 'faculty_id', 'designation', 'qualification',
        'specialization', 'experience', 'phone', 'address', 'date_of_birth',
        'gender', 'joining_date', 'salary', 'profile_photo', 'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joining_date'  => 'date',
        'salary'        => 'decimal:2',
    ];

    public function user()       { return $this->belongsTo(User::class); }
    public function department() { return $this->belongsTo(Department::class); }
    public function subjects()   { return $this->belongsToMany(Subject::class, 'subject_faculty')->withPivot('academic_year', 'semester')->withTimestamps(); }
    public function attendance() { return $this->hasMany(Attendance::class); }
    public function results()    { return $this->hasMany(Result::class); }
    public function assignments(){ return $this->hasMany(Assignment::class); }
    public function studyMaterials(){ return $this->hasMany(StudyMaterial::class); }

    public function getNameAttribute(): string { return $this->user->name ?? ''; }
    public function getEmailAttribute(): string{ return $this->user->email ?? ''; }

    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo && file_exists(public_path('uploads/faculty/' . $this->profile_photo))) {
            return asset('uploads/faculty/' . $this->profile_photo);
        }
        return $this->user->avatar_url ?? asset('images/avatar-default.jpg');
    }
}
