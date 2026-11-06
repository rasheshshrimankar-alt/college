<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Placement extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id', 'company_name', 'position', 'package_lpa', 'placement_type',
        'academic_year', 'offer_date', 'company_logo', 'status'
    ];
    protected $casts = ['offer_date' => 'date', 'package_lpa' => 'decimal:2'];
    public function student() { return $this->belongsTo(Student::class); }
}
