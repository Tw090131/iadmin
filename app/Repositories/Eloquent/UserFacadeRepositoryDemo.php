<?php
/**
 * 门面模式事例
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/11/8
 * Time: 10:20
 */

namespace App\Repositories\Eloquent;
use App\Repositories\Contracts\UserInterface;
use App\User;

class UserFacadeRepository implements UserInterface{

    public function findBy($id)
    {
         return User::find($id);
    }
}