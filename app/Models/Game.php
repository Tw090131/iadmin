<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use ActionAttributeTrait;
    private $action;
    protected $table = 'game';
    protected $fillable = [
        'game_name',
        'cp_uid',
        'appid',
        'appsecret',
        'sort',
    ];

    public function __construct()
    {
        $this->action = config('admin.globals.game.action');
        //dd(config('admin.globals.permission.action'));
    }
}
