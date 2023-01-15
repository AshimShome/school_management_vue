<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];
    protected $appends = ['image_url'];

    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }

    public function getImageUrlAttribute(){
        if (is_null($this->image)) {
            return asset('images/demo.png');
        }
        return asset($this->image);
    }
}
