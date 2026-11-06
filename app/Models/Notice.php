<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notice extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'content', 'category', 'target', 'attachment',
        'publish_date', 'expiry_date', 'created_by', 'is_important', 'status'
    ];
    protected $casts = ['publish_date' => 'date', 'expiry_date' => 'date', 'is_important' => 'boolean'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
