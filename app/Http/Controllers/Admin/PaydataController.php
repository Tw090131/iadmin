<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaydataController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.appid');//后面的为控制器名称就好了
        $this->middleware('check.permission:paydata');//后面的为控制器名称就好了
    }

    public function bill(){
       return view('admin.paydata.bill');
    }

    public function payrate(){
        return view('admin.paydata.payrate');
    }

    public function ltv(){
        return view('admin.paydata.ltv');
    }
}
