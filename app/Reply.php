<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected  $table = 'reply';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'target_seq', 'user_seq', 'comment', 'user_ip', 'create_dt', 'update_dt'
    ];
}
