<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquent\GameRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\GameRequest;
//use App\Repositories\Eloquent\PermissionRepository;

class GameController extends Controller
{
    private $game;

    public function __construct(GameRepository $game)
    {
      //  $this->middleware('check.permission:game');//后面的为控制器名称就好了
        $this->game = $game;
    }
    public function lostlevel()
    {
        return view('admin/game/lostlevel');
    }

    public function getLostLevel()
    {
        return response()->json([['device'=>'iPhone 4', 'geekbench'=> 380],['device'=>'iPhone 4', 'geekbench'=> 380]]);
    }


    public function index(Request $request){
        return view('admin/game/list');
    }

    public function ajaxIndex()
    {
        $result = $this->game->ajaxIndex();
        // return   json_encode($result);
        return response()->json($result);
    }


    public function create()
    {
        return view('admin.game.create');
    }

    public function store(GameRequest $request)
    {
        $this->game->createGame($request->all());
        return redirect('admin/index/gamelist');
    }


}
