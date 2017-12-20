<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    protected $primaryKey = 'short_code';
    protected $keyType = 'string';
    public  $incrementing = false;
    protected $table = 'clicks';

    protected $guarded = [];
}
