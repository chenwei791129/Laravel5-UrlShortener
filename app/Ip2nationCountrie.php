<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ip2nationCountrie extends Model
{
    protected $primaryKey = null;
    public  $incrementing = false;
    protected $table = 'ip2nationCountries';
    public $timestamps = false;
}
