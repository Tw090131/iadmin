<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
   // private $menu;

    public function __construct()
    {
      //  $this->middleware('check.permission:game');//后面的为控制器名称就好了
        //$this->menu = $menu;
    }
    public function lostlevel()
    {
        return view('admin/game/lostlevel');
    }

    public function getLostLevel()
    {
        return response()->json([['device'=>'iPhone 4', 'geekbench'=> 380],['device'=>'iPhone 4', 'geekbench'=> 380]]);
    }
}
