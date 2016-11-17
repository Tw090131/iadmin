<?php
/**  仓库模式  之 用户的仓库

 * Created by PhpStorm.
 * User: 95
 * Date: 2016/11/8
 * Time: 11:25
 */

namespace App\Repositories\Eloquent;
use App\User;

class UserRepository extends Repository
{
    //继承抽象类 必须实现抽象方法
    public function model()
    {
        return User::class;
    }

    //这里还可一继续重写 repository 中的方法
    public function findBy($id)
    {
        return $this->model->where('id',$id)->first()->toArray();
    }

}