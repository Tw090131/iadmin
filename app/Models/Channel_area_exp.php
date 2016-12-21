<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel_area_exp extends Model
{
    protected $table = 'channel_area_exp';
    protected $fillable = [
        'appid',
        'world',
        'cid',
        'area_id',
        'exp_num',
        'new_account_num',
        'new_role_num',
        'scroll_num',
        'enter_game_num'
    ];
}
