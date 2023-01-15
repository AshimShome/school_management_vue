<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['favicon_url', 'logo_url', 'dark_logo_url','currency_sign'];

    public function session()
    {
        return $this->belongsTo(Session::class, 'default_session_id', 'id');
    }


    public function getFaviconUrlAttribute()
    {
        if (is_null($this->favicon)) {
            return asset('images/fav/favicon.png');
        }
        return asset($this->favicon);
    }

    public function getLogoUrlAttribute()
    {
        if (is_null($this->logo)) {
            return asset('images/logo/logo.png');
        }
        return asset($this->logo);
    }

    public function getDarkLogoUrlAttribute()
    {
        if (is_null($this->dark_logo)) {
            return asset('images/logo/logo.png');
        }
        return asset($this->dark_logo);
    }

    public function getCurrencySignAttribute()
    {
        return env('APP_CURRENCY_SYMBOL', '$');
    }

}
