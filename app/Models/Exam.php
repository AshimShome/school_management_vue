<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'note', 'session_id', 'start_date', 'end_date'
    ];

    protected $casts = [''];



    public function term()
    {
        return $this->belongsTo(ExamTerm::class);
    }

    public function schedules()
    {
        return $this->hasMany(ExamSchedule::class);
    }
}
