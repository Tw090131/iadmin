<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function getChannels($appid){
        $game = Game::where(['appid'=>$appid])->first();
        $accounts_cid = Cache::get(config('admin.globals.cache.account'))->where('gid',$game->id)->groupBy('cid')->toArray();
        $channels = [];
        foreach($accounts_cid as $k => $v){
            $channels[]=$v[0]['cid'];
        }
        return $channels;
    }

    public function getAreas($appid){
        $game = Game::where(['appid'=>$appid])->first();
        $accounts_area_id = Cache::get(config('admin.globals.cache.account'))->where('gid',$game->id)->groupBy('create_of_area')->toArray();
        $areas = [];
        foreach($accounts_area_id as $k => $v){
            $areas[]=$v[0]['create_of_area'];
        }
        return $areas;
    }
}
