<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shorturl extends Model
{
    protected $guarded = [];

    public function clicks()
    {
        return $this->hasMany('App\Click', 'short_code', 'short_code');
    }
}
