<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeePayment extends Model
{
    use HasFactory;
    protected $table = 'fee_payments';
    protected $fillable = [
        'student_id', 'fee_id', 'transaction_id', 'amount_paid', 'payment_date',
        'payment_method', 'receipt_number', 'status', 'remarks'
    ];
    protected $casts = ['payment_date' => 'date', 'amount_paid' => 'decimal:2'];
    public function student() { return $this->belongsTo(Student::class); }
    public function fee()     { return $this->belongsTo(Fee::class); }
}
