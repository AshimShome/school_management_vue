<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Staff;
use App\Models\Classs;
use App\Models\Section;
use App\Models\Subject;
use App\Models\ClassRoom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassRoutine extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id', 'class_id', 'section_id', 'class_room_id', 'teacher_id', 'subject_id', 'weekday', 'start_time', 'end_time'
    ];

    const WEEK_DAYS = [
        '1' => 'Monday',
        '2' => 'Tuesday',
        '3' => 'Wednesday',
        '4' => 'Thursday',
        '5' => 'Friday',
        '6' => 'Saturday',
        '7' => 'Sunday',
    ];

    public function getDifferenceAttribute()
    {
        return Carbon::parse($this->end_time)->diffInMinutes($this->start_time);
    }

    public function getStartTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('panel.lesson_time_format')) : null;
    }

    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = $value ? Carbon::createFromFormat(config('panel.lesson_time_format'),
            $value)->format('H:i:s') : null;
    }

    public function getEndTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('panel.lesson_time_format')) : null;
    }

    public function setEndTimeAttribute($value)
    {
        $this->attributes['end_time'] = $value ? Carbon::createFromFormat(config('panel.lesson_time_format'),
            $value)->format('H:i:s') : null;
    }

    public function scopeCalendarByRoleOrClassId($query)
    {
        return $query->when(!request()->input('class_id'), function ($query) {
            $query->when(auth()->user()->role == 'student', function ($query) {
                $query->where('teacher_id', auth()->user()->id);
            })
                ->when(auth()->user()->role == 'staff', function ($query) {
                    $query->where('class_id', auth()->user()->class_id ?? '0');
                });
        })->when(request()->input('class_id'), function ($query) {
            $query->where('class_id', request()->input('class_id'));
        });
    }

    public function classs()
    {
        return $this->belongsTo(Classs::class, 'class_id', 'id');
    }

    public function class_room()
    {
        return $this->belongsTo(ClassRoom::class, 'class_room_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id', 'id');
    }
}
