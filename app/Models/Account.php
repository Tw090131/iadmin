<?php

namespace App\Models;
use App\Traits\HomeNoticeTrait;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HomeNoticeTrait;
   // public $timestamps = false;//不需要 created_at  和 updated_at
    protected $table = 'account';
    protected $fillable = [
        'openid',
        'cid',
        'gid',
        'register_time',
        'world',
        'create_of_area',
        'login_time',
        'leave_time',
    ];
}
