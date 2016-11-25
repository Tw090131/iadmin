<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BaseDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.appid');//后面的为控制器名称就好了
        $this->middleware('check.permission:basedata');//后面的为控制器名称就好了
    }

    //数据总览
    public function all(){
        return view('admin.basedata.all');
    }

    //帐号/活跃
    public function active(){
        return view('admin.basedata.active');
    }

    //角色概况
    public function roles(){
        return view('admin.basedata.roles');
    }
    //实时在线
    public function online(){
        return view('admin.basedata.online');
    }

    //留存率
    public function retention(){

        return view('admin.basedata.retention');
    }

    //流失率
    public function lossrate(){

        return view('admin.basedata.lossrate');
    }

}
