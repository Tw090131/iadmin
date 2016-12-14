<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\DailydataRepository;
class RetentionController extends Controller
{
    private $dailydata;
    public function __construct(DailydataRepository $dailydata)
    {
        $this->middleware('check.appid');//后面的为控制器名称就好了
        $this->middleware('check.permission:basedata');//后面的为控制器名称就好了
        $this->dailydata=$dailydata;
    }
    //留存率
    public function retention(){
        $appid = request()->appid;
        $channels=$this->getChannels($appid);
        $areas = $this->getAreas($appid);
        return view('admin.basedata.retention',compact(['channels','areas']));
    }

    public function ajaxRetentionIndex()
    {
        $appid = request()->appid;
        $result = $this->dailydata->ajaxRetentionIndex($appid);
        // return   json_encode($result);
        return response()->json($result);
    }


    //流失率
    public function lossrate(){

        return view('admin.basedata.lossrate');
    }
}
