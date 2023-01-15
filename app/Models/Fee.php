<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id', 'parent_id', 'student_id', 'class_id', 'section_id', 'type_id', 'amount', 'due_date', 'pay_date', 'transaction_no', 'description', 'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Guardian::class, 'parent_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(FeeType::class, 'type_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo(Classs::class, 'class_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
}
