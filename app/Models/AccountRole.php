<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountRole extends Model
{
    protected $table = 'account_role';
    protected $fillable = [
        'openid',
        'rid',
        'aid',
        'role_name',
        'register_time',
        'level',
        'gk_num',
        'vip',
        'recharge',
        'has_heros_num',
        'area_id',
        'login_time',
        'leave_time',
        'cid',
        'gid',
    ];
}
