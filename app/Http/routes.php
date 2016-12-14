<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/','Admin\IndexController@gamelist')->middleware('auth');

Route::auth();

Route::get('/test/{id}', 'TestController@index');

//Route::group(['prefix' => 'admin' ],function($router) {
//        Route::get('test/index', 'TestController@index')->name('abc');
//});

Route::group(['namespace' => 'Admin','prefix' => 'admin','middleware'=>['auth'] ],function($router){
    // 首页路由
    require(__DIR__.'/Routes/AdminIndexRoute.php');
    // 菜单路由
    require(__DIR__.'/Routes/MenuRoute.php');
    // 权限路由
    require(__DIR__.'/Routes/PermissionRoute.php');
    // 角色
    require(__DIR__ . '/Routes/RoleRoute.php');
    /*用户*/
    require(__DIR__ . '/Routes/UserRoute.php');
    /*游戏分析*/
    require(__DIR__ . '/Routes/GameRoute.php');
    /*后台首页游戏列表*/
    require(__DIR__ . '/Routes/IndexRoute.php');
    /*后台首页游戏列表*/
    require(__DIR__ . '/Routes/BasedataRoute.php');
    /*留存统计*/
    require(__DIR__ . '/Routes/RetentionRoute.php');
    /*后台付费数据*/
    require(__DIR__ . '/Routes/PaydataRoute.php');
    /*后台充值数据*/
    require(__DIR__ . '/Routes/RechargeRoute.php');
    /*后台渠道区服数据*/
    require(__DIR__ . '/Routes/ChannelAreaRoute.php');


    Route::get('/tools/icon', 'ToolsController@icon');
});

//Home
Route::group(['namespace' => 'Home','prefix' => 'home' ],function($router){
    require(__DIR__ . '/Routes/HomeRoute.php');
});