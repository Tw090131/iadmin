<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\Eloquent\UserRepository;

class UserController extends Controller
{
    private $user;

    function __construct(UserRepository $user)
    {
       // $this->middleware('check.permission:user');//后面的为控制器名称就好了
        $this->user = $user;
    }

    public function index()
    {
        return view('admin/user/list');
    }

    public function ajaxIndex()
    {
        $result = $this->user->ajaxIndex();
        // return   json_encode($result);
        return response()->json($result);
    }
}
