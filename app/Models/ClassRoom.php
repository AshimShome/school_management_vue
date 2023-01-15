<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    protected $fillable = ['room_no', 'capacity','image'];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if (is_null($this->image)) {
            return asset('images/demo.png');
        }
        return asset($this->image);
    }
}
