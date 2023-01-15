<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamTerm extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'note'];



    public function exams()
    {
        return $this->hasMany(Exam::class, 'term_id', 'id');
    }

    public function syllabuses()
    {
        return $this->hasMany(Syllabus::class, 'term_id', 'id');
    }
}
