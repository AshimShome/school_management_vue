<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug','image'];
    protected $appends = ['image_url'];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['slug'] = Str::slug($name);
    }

    public function getImageUrlAttribute()
    {
        if (is_null($this->image)) {
            return asset('images/demo.png');
        }
        return asset($this->image);
    }
}
