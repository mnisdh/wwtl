<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rateitem extends Model
{
    protected  $table = 'rate_item';
    public $timestamps = false;
    protected $primaryKey = 'rate_item';

    protected $fillable = [
        'rate_item', 'rate_type', 'name', 'use_yn', 'idx'
    ];
}
