<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'session_id', 'class_id', 'section_id', 'date', 'status'];

    protected $casts = [
        'type' => 'boolean',
        'status' => 'boolean'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
