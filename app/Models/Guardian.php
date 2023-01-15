<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'phone', 'session_id', 'gender','occupation'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function childs()
    {
        return $this->hasMany(Student::class, 'parent_id', 'id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'parent_id', 'id');
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }
}
