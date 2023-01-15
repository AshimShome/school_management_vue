<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id', 'status', 'date', 'session_id'
    ];

    protected $casts = [
        'status'      =>  'boolean'
    ];

    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id', 'id');
    }
}
