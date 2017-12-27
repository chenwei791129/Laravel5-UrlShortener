<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shorturl extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function clicks()
    {
        return $this->hasMany('App\Click', 'short_code', 'short_code');
    }
}
