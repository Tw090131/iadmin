<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
   // public $timestamps = false;//不需要 created_at  和 updated_at
    protected $table = 'account';
    protected $fillable = [
        'openid',
        'cid',
        'register_time',
        'word',
        'create_of_area',
    ];
}
