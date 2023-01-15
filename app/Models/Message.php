<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'messageable_type ', 'messageable_id', 'message', 'message_type'
    ];

    /**
     * Get the parent messageable model (user or post).
     */
    public function messageable()
    {
        return $this->morphTo();
    }


    public function user(){
        return $this->belongsTo(User::class, 'messageable_id','id');
    }
}
