<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibraryBook extends Model
{
    use HasFactory;
    protected $table = 'library_books';
    protected $fillable = [
        'title', 'author', 'isbn', 'publisher', 'publication_year', 'category',
        'total_copies', 'available_copies', 'location', 'cover_image', 'description', 'status'
    ];
    public function issues() { return $this->hasMany(BookIssue::class); }
}
