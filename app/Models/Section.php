<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Classs;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','capacity'];

    /**
     * Section slug mutator.
     *
     * @param  string  $value
     * @return void
    */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['slug'] = Str::slug($name);
    }

    public function classes()
    {
        return $this->belongsToMany(Classs::class, 'class_section','section_id','class_id');
    }


}
