<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ChannelAreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.appid');//后面的为控制器名称就好了
        $this->middleware('check.permission:channel_area');//后面的为控制器名称(就是slug的第二级)就好了
    }
    public function channeldata(){
       return view('admin/c-a/channeldata');
    }

    public function areadata(){
        return view('admin/c-a/areadata');
    }
}
