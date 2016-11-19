<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public  function __construct()
    {
        $this->middleware('check.permission:home');//后面的为控制器名称就好了
    }

    public function index()
    {
        return view('admin/home/index');
    }
}
