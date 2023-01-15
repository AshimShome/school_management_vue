<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'department_id', 'designation', 'joining_date', 'phone', 'gender', 'religion', 'bio', 'joining_letter', 'resume', 'other_document','present_address','permanent_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendances()
    {
        return $this->hasMany(TeacherAttendance::class, 'teacher_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
