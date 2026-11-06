<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookIssue extends Model
{
    use HasFactory;
    protected $table = 'book_issues';
    protected $fillable = [
        'library_book_id', 'student_id', 'issue_date', 'due_date', 'return_date', 'fine_amount', 'status'
    ];
    protected $casts = ['issue_date' => 'date', 'due_date' => 'date', 'return_date' => 'date'];
    public function book()    { return $this->belongsTo(LibraryBook::class, 'library_book_id'); }
    public function student() { return $this->belongsTo(Student::class); }
}
