<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected  $table = 'user';
    protected $primaryKey = 'seq';

    public $timestamps = false;

    protected $fillable = [
        'name', 'email', 'password', 'auth_key', 'dt_create', 'dt_update',
        'nick_name', 'photo', 'birth', 'gender', 'job', 'locale', 'locale_cd',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
