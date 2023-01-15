<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResultRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'gpa', 'min_mark', 'max_mark'
    ];

    protected $casts = [
        'gpa' => 'float',
    ];
}
