<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ip2nation extends Model
{
    protected $primaryKey = null;
    public  $incrementing = false;
    protected $table = 'ip2nation';
    public $timestamps = false;
}
