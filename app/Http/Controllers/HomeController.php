<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //判断用户有没有admin权限
     //   dd(auth()->user()->hasRole('admin'));//auth()->user()   ===Auth::user()   用Auth：要use下
      //  dd(auth()->user()->hasRole('user'));


        //判断用户是否有相应的权限
       // dd(auth()->user()->can('create users'));//里面放name
        //Entrust::hasRole()   === Auth::user()->hasRole()  都要use一下


        //匹配模式  判断用户相应的权限
       // dd(auth()->user()->can('*users'));


        //多个一起判断
      //  dd(auth()->user()->can(['create users','aaa'],true));//或者的判断   可以第二个参数上写true 为并
       // dd(auth()->user()->hasRole(['admin','user'],true));

        //检查 用户有那些角色  那些权限
//        $options = array(
//            'validate_all' => true | false (Default: false),
//                'return_type'  => boolean | array | both (Default: boolean)
//            );

        $options = array(
            'validate_all' => true,
            'return_type' => 'both'
        );

        //判断某个用户相应的权限
        //dd(auth()->user()->ability(array('admin','user'),array('create users','edit users'),$options));//也是或判断    第三个参数
      /*
       * array:2 [▼
          0 => false  //没有user 的角色
          1 => array:2 [▼
            "roles" => array:2 [▼
              "admin" => true
              "user" => false
            ]
            "permissions" => array:2 [▼
              "create users" => true
              "edit users" => true
            ]
          ]
        ]
       * */

        return view('home');
    }
}
