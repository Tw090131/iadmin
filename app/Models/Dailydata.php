<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dailydata extends Model
{
    protected $table = 'dailydata';
    protected $fillable = [
        'type',
        'gid',
        'cid',
        'area_id',
        'date',
        'new_exp',
        'new_account_num',
        'create_account_rate',
        'new_role_num',
        'create_role_rate',
        'active_account_num',
        'active_role_num',
        'active_pay_num',
        'active_pay_rate',
        'active_pay_money',
        'new_pay_num',
        'new_pay_rate',
        'new_pay_money',
        'income',
        'old_account_num',
        'old_account_login_num',
        'old_account_active_rate',
        'lc2',
        'lc3',
        'lc7',
        'lc15',
        'lc30',
        'lc60',
        'lc90',
        'account_register_arpu',
        'account_active_arpu',
        'account_register_arrpu',
        'account_active_arrpu',
        'enter_game_num',
        'lost_exp_rate',
        'lost_account_rate',

    ];
}
