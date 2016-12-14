<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    protected $table = 'system';
    protected $fillable = [
        'index_click_all',
        'point1',
        'point2',
        'enter_game_num',
        'game1_mum',
        'date',
        'appid',
        'area_id',
    ];
}
