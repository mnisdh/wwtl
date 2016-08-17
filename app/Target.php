<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected  $table = 'target';
    public $timestamps = false;
    protected $primaryKey = 'seq';

    protected $fillable = [
        'user_seq','user_ip', 'dt_create', 'dt_update',
        'first_name', 'last_name', 'nick_name', 'photo', 'birth', 'gender', 'job', 'country', 'locale', 'locale_cd', 'lat', 'lng'
    ];

    protected $dateFormat = 'Y-m-d';
}
