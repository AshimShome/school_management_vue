<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',  'transaction_no', 'student_id', 'income_type', 'expense_type', 'payment_type', 'amount', 'type'
    ];

    public function scopeCurrentSession($query)
    {
        return $query->whereSessionId(currentSession());
    }
}
