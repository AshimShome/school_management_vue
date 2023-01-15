<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id', 'exam_id', 'class_id', 'section_id', 'subject_id', 'roll_no', 'mark', 'note'
    ];

    public function setSessionIdAttribute()
    {
        $this->attributes['session_id'] = adminSetting()->default_session_id;
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function classs()
    {
        return $this->belongsTo(Classs::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
