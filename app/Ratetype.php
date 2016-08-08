<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ratetype extends Model
{
    protected  $table = 'rate_type';
    public $timestamps = false;
    protected $primaryKey = 'rate_type';

    protected $fillable = [
        'rate_type', 'name', 'use_yn', 'idx'
    ];
}
