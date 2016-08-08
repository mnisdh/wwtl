<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RateScore extends Model
{
    protected  $table = 'rate_score';
    public $timestamps = false;
    protected $primaryKey = 'rate_id';


    protected $fillable = [
        'target_seq', 'rate_id', 'rate_item', 'score'
    ];
}
