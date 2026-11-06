<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scholarship extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'provider', 'amount', 'eligibility', 'application_deadline', 'apply_link', 'status'
    ];
    protected $casts = ['application_deadline' => 'date', 'amount' => 'decimal:2'];
}
