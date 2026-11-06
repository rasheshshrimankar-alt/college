<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role', 'avatar', 'status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Role helpers
    public function isAdmin(): bool    { return in_array($this->role, ['admin', 'super_admin']); }
    public function isFaculty(): bool  { return $this->role === 'faculty'; }
    public function isStudent(): bool  { return $this->role === 'student'; }
    public function isSuperAdmin(): bool { return $this->role === 'super_admin'; }

    public function student()   { return $this->hasOne(Student::class); }
    public function faculty()   { return $this->hasOne(Faculty::class); }
    public function complaints(){ return $this->hasMany(Complaint::class); }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && file_exists(public_path('uploads/avatars/' . $this->avatar))) {
            return asset('uploads/avatars/' . $this->avatar);
        }
        $initials = urlencode(substr($this->name, 0, 1));
        return "https://ui-avatars.com/api/?name={$initials}&background=3157D5&color=fff&size=128";
    }
}
