<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use Illuminate\Support\Str;

class Classs extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'numeric'];

    /**
     * Class slug mutator.
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['slug'] = Str::slug($name);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'class_section', 'class_id', 'section_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class,'class_id','id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'class_id', 'id');
    }

    public function syllabuses()
    {
        return $this->hasMany(Syllabus::class, 'class_id', 'id');
    }
}
