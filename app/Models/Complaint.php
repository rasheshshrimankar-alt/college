<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Complaint extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'subject', 'description', 'category', 'attachment',
        'priority', 'status', 'admin_response', 'resolved_by', 'resolved_at'
    ];
    protected $casts = ['resolved_at' => 'datetime'];
    public function user()     { return $this->belongsTo(User::class); }
    public function resolver() { return $this->belongsTo(User::class, 'resolved_by'); }
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'in_progress' => '<span class="badge bg-warning text-dark">In Progress</span>',
            'resolved'    => '<span class="badge bg-success">Resolved</span>',
            'closed'      => '<span class="badge bg-secondary">Closed</span>',
            default       => '<span class="badge bg-danger">Open</span>',
        };
    }
}
