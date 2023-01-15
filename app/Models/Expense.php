<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['session_id','type_id', 'amount', 'description','transaction_no'];

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class,'type_id','id');
    }
}
