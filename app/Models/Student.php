<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'parent_id', 'session_id', 'class_id', 'section_id', 'roll_no', 'phone', 'admission_date', 'gender', 'date_of_birth', 'blood_group','present_address','permanent_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classs()
    {
        return $this->belongsTo(Classs::class, 'class_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class, 'parent_id', 'id');
    }

    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class);
    }

    public function marks()
    {
        return $this->hasMany(ExamMark::class, 'roll_no', 'roll_no');
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }
}
