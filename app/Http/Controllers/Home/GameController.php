<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\AccountRepository;
class GameController extends Controller
{
    private $account ;
    public function __construct(AccountRepository $account)
    {
        $this->account = $account;
    }
    /*选区创角色
     * parms openid     char(32)  用户帐号openid
     * parms cid         int       渠道id
     * parms world       varchar   帐号创建的物理服务器
     * parms create_of area  int   帐号创建的区
    * url:    post.home/game/init
     * */

    public function inituser(Request $request){
       $account =  $this->account->inituser($request->all());
        dd($account);
    }

    public function test(){


        return view('home/test');
    }
}
