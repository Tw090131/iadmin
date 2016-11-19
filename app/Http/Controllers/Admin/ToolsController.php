<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ToolsController extends Controller
{

    function __construct()
    {
        $this->middleware('check.permission:tools');//后面的为控制器名称就好了

    }
    public function icon()
    {

        return view('admin/tools/icons');
    }
}
