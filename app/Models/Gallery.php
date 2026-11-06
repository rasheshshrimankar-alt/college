<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;
    protected $table = 'gallery';
    protected $fillable = ['title', 'description', 'image_path', 'category', 'is_featured', 'created_by', 'status'];
    protected $casts = ['is_featured' => 'boolean'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function getImageUrlAttribute(): string { return asset('uploads/gallery/' . $this->image_path); }
}
