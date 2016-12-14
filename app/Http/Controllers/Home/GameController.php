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
class GameController extends Controller
{

    private $account ;
    private $account_role;
    private  $system;
    private  $dailydata;
    public function __construct(AccountRepository $account,AccountRoleRepository $account_role,SystemRepository $system,DailydataRepository $dailydata)
    {
        $this->account = $account;
        $this->account_role=$account_role;
        $this->system=$system;
        $this->dailydata=$dailydata;
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

//        for($i=0;$i<7;$i++){
//            dump(time()-3600*24*$i);
//        }
//        dd(111);

        $input =$request->all();
        $appid = isset($input['appid'])?$input['appid']:null;
        //判断是否进行统计
        $dailydata = $this->system->dailyStatistic($appid);  //这里 判断是否 需要拆入每天数据   需要的时候才会写缓存 account  和account_role

        if(!isset($dailydata['code']) && $dailydata != false){
           //如果需要更新的话
            //dd($dailydata);
            $this->dailydata->addDailydata($dailydata);

        }

        switch(isset($input['type'])?$input['type']:0){
            case 1:
                $result =  $this->account->initaccount($request->all());
                break;
            case 2:
                $result = $this->account_role->initrole($request->all());
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
     * @parms type  int
     * */
    public function addMaidian(Request $request){
       return  $this->system->addMaidian($request->all());
    }



    public function test(){

        return view('home/test');
    }
}
