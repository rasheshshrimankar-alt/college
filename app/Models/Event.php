<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'image', 'venue', 'start_datetime', 'end_datetime',
        'organizer', 'category', 'created_by', 'status'
    ];
    protected $casts = ['start_datetime' => 'datetime', 'end_datetime' => 'datetime'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('uploads/events/' . $this->image))) {
            return asset('uploads/events/' . $this->image);
        }
        return asset('images/event-default.jpg');
    }
}
