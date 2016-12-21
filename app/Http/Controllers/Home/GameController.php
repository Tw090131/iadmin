<?php

namespace App\Http\Controllers\Home;

use App\Models\System;
use App\Repositories\Eloquent\SystemRoleRepository;
use Illuminate\Http\Request;
use App\Traits;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\AccountRepository;
use App\Repositories\Eloquent\AccountRoleRepository;
use App\Repositories\Eloquent\SystemRepository;
use App\Repositories\Eloquent\DailydataRepository;
use App\Repositories\Eloquent\ChannelAreaExpRepository;
use Illuminate\Support\Facades\Cache;

class GameController extends Controller
{

    private $account ;
    private $account_role;
    private  $system;
    private  $dailydata;
    private $channel_area_exp;
    public function __construct(AccountRepository $account,AccountRoleRepository $account_role,SystemRepository $system,DailydataRepository $dailydata,ChannelAreaExpRepository $channel_area_exp)
    {
        $this->account = $account;
        $this->account_role=$account_role;
        $this->system=$system;
        $this->dailydata=$dailydata;
        $this->channel_area_exp=$channel_area_exp;
    }


    /*选区创帐号
     * @parms openid     char(32)  用户帐号openid
     * @parms cid         int       渠道id
     * @parms [world]       varchar   帐号创建的物理服务器
     * @parms create_of area  int   帐号创建的区
     * @parms type       int       1初始化帐号  2初始化角色
    * url:    post.home/game/init
     * */

    public function inituser(Request $request){

//        for($i=1;$i<7;$i++){
//            dump(time()-3600*24*$i);
//        }
//        dd(111);

        if(isset( $input['world'])){
            $world = preg_replace('/^( |\s)*|( |\s)*$/', '', $input['world']);
            if($world == ''){
                $input['world']='0';
            }
        }



        switch(isset($input['type'])?$input['type']:0){
            case 1:
             //   $result =  $this->account->initaccount($input);
                break;
            case 2:
                $result = $this->account_role->initrole($input);
                break;
            default:
                return ['code'=>trans('homenotice.type')];
        }

       // dd(date('Ymd',$account->login_time));
        return $result;
    }


    //埋点
    /*
     * @parms appid
     * @parms openid
     * @parms world
     * @parms cid
     * @parms area_id
     * @parms type  int  1导入量  2 帐号埋点 3 角色埋点  4进入游戏
     * */
    public function addMaidian(Request $request){

        $input =$request->all();

       $appid = isset($input['appid'])?$input['appid']:null;

        //判断是否进行统计

        $dailydata = $this->system->dailyStatistic($appid);  //这里 判断是否 需要拆入每天数据   需要的时候才会写缓存 account  和account_role
    //    dd($dailydata);

        if(!isset($dailydata['code']) && $dailydata != false){
            //如果需要更新的话
            $this->dailydata->addDailydata($dailydata);
        }else{
            return $dailydata;
        }

        if(isset( $input['world'])){
            $world = preg_replace('/^( |\s)*|( |\s)*$/', '', $input['world']);
            if($world == ''){
                $input['world']='0';
            }
        }

       return  $this->channel_area_exp->addMaidian($input);
    }



    public function test(){

        return view('home/test');
    }
}
