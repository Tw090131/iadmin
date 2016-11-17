<?php
/**
 *
 * 服务模式 事例
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/11/7
 * Time: 17:53
 */
namespace App\Repositories\Eloquent;
use App\Repositories\Contracts\UserInterface;
use App\User;

class UserServiceRepository implements  UserInterface{
    public function findBy($id)
    {
        return User:: find($id);
    }
}