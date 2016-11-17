<?php
/**
 * 用户门面  demo
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/11/8
 * Time: 10:24
 */

namespace App\Facades;
/*
用户仓库门面
*/
use Illuminate\Support\Facades\Facade;
class UserFacade extends Facade{
    /**
     * 获取组件注册名称
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'UserFacadeRepository';  //
    }
}