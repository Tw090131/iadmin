<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\UserInterface;
use Illuminate\Http\Request;
use UserRepository;
use App\Http\Requests;
use App\Repositories\Eloquent\UserRepository as UserRepo;

class TestController extends Controller
{
    private  $user;
    private  $userRepo;
//    public function __construct(UserInterface $user ,UserRepo $userRepo)  //引用userinterface 会自动到repositoryserviceprovider中实例化
//    {
//
//        $this->user = $user;
//        $this->userRepo = $userRepo;
//    }

    public function index(){
        //服务模式
       // dd($this->user->findBy(1)->toArray());


        //门面模式
        //dd(UserRepository::findBy(1)->toArray());

        //仓库模式
//        dd($this->userRepo->findBy(2));
        echo 111;
    }
}
