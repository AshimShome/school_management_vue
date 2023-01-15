<?php

namespace App\Models;

use Database\Factories\HomeworkFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHomework extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'teacher_id', 'session_id', 'class_id', 'section_id', 'subject_id', 'start_date', 'end_date', 'description'];

    protected static function newFactory()
    {
        return HomeworkFactory::new();
    }

    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
