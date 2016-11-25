<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RechargeController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.appid');//后面的为控制器名称就好了
        $this->middleware('check.permission:recharge');//后面的为控制器名称就好了
    }
    public function record(){
        return view('admin/recharge/record');
    }

    public function rank(){
        return view('admin/recharge/rank');
    }

    public function vip(){
        return view('admin/recharge/vip');
    }

    public function first(){
        return view('admin/recharge/first');
    }
}
