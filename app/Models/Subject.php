<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['image_url'];

    public function classes()
    {
        return $this->belongsTo(Classs::class, 'class_id', 'id');
    }

    public function getImageUrlAttribute()
    {
        if (is_null($this->image)) {
            return asset('images/demo.png');
        }
        return asset($this->image);
    }
}
