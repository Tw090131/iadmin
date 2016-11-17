<?php
/** 仓库模式  的   抽象类   相当于基类
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/11/8
 * Time: 11:20
 */

namespace App\Repositories\Eloquent;
use App\Repositories\Contracts\UserInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
abstract class Repository implements UserInterface{

    /*App容器*/
    protected $app;

    /*操作model*/
    protected $model;

    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();//获取继承他仓库的model
    }

    abstract function model();

    public function findBy($id)
    {
        return $this->model->find($id);
    }
    /**
     * 统计数量
     * @author 晚黎
     * @date   2016-07-21T17:09:32+0800
     * @param  string                   $field   [description]
     * @param  string                   $value   [description]
     * @param  array                    $columns [description]
     * @return [type]                            [description]
     */
    public function count($field='',$value='',$columns = array('*')){
        if (is_array($field) && is_array($value)) {
            $where = array_combine($field,$value);
            $this->model = $this->model->where($where);
        }
        if (is_string($field) && is_string($value)) {
            $this->model = $this->model->where($field,$value);
        }
        return $this->model->select($columns)->count();
    }

    public function makeModel(){
        $model = $this->app->make($this->model());//相当于在框架中new 一下model
        /*是否是Model实例*/
        if (!$model instanceof Model){ //判断是否继承的是laravel 中的model  不是的话抛出异常
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        $this->model = $model;
    }


}