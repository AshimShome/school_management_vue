<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'session_id','exam_id','room_id','class_id','subject_id','section_id','exam_date','start_time','end_time','note'
    ];


    public function classs(){
        return $this->belongsTo(Classs::class,'class_id','id');
    }


    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }


    public function exam(){
        return $this->belongsTo(Exam::class);
    }

    public function room(){
        return $this->belongsTo(ClassRoom::class,'room_id', 'id');
    }

    //
}
