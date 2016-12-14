<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\DailydataRepository;
use App\Repositories\Eloquent\AccountRoleRepository;
use Illuminate\Support\Facades\Cache;
use Orchestra\Support\Facades\Config;

class BaseDataController extends Controller
{
    private $dailydata;
    private  $account_role;
    public function __construct(DailydataRepository $dailydata,AccountRoleRepository $account_role)
    {
        $this->middleware('check.appid');//后面的为控制器名称就好了
        $this->middleware('check.permission:basedata');//后面的为控制器名称就好了
        $this->dailydata=$dailydata;
        $this->account_role=$account_role;
    }

    //数据总览
    public function all(){
        $appid = request()->appid;
        $channels=$this->getChannels($appid);
        $areas = $this->getAreas($appid);
        return view('admin.basedata.all',compact(['channels','areas']));
    }



    public function ajaxBasedataAll()
    {
        $appid = request()->appid;

        $result = $this->dailydata->ajaxRetentionIndex($appid);
        // return   json_encode($result);
        return response()->json($result);
    }

    //帐号/活跃
    public function active(){
        $appid = request()->appid;
        $channels=$this->getChannels($appid);
        $areas = $this->getAreas($appid);
        return view('admin.basedata.active',compact(['channels','areas']));
    }



    //角色概况
    public function roles(){
        return view('admin.basedata.roles');
    }
    public function ajaxBasedataRoles()
    {
        $appid = request()->appid;

        $result = $this->account_role->ajaxBasedataRoles($appid);

        return response()->json($result);
    }


    //实时在线
    public function online(){
        return view('admin.basedata.online');
    }



}
