<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';
    protected $fillable = [
        'title', 'content', 'image', 'category', 'slug', 'created_by', 'is_featured', 'views', 'status'
    ];
    protected $casts = ['is_featured' => 'boolean'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title) . '-' . Str::random(5);
            }
        });
    }
    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('uploads/news/' . $this->image))) {
            return asset('uploads/news/' . $this->image);
        }
        return asset('images/news-default.jpg');
    }
}
