<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RateMain extends Model
{
    protected  $table = 'rate_main';
    public $timestamps = false;
    protected $primaryKey = 'target_seq';

    protected $fillable = [
        'target_seq', 'rate_id', 'user_seq', 'user_ip', 'rate_type', 'rate_score', 'knew_year','comment', 'dt_create', 'dt_update'
    ];
}
