<?php
/*接口实现类*/

namespace App\Repositories\Eloquent;
use App\Repositories\Contracts\RepositoryInterface;
//use App\Repositories\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

abstract class Repository implements RepositoryInterface   //继承了RepositoryInterface  要实现他的全部方法
{
	protected $app;//app容器

	protected $model;//操作的model

	public function __construct(App $app)
	{
		$this->app = $app;
		$this->makeModel();//获取到继承仓库的model
	}

	abstract public function model();//获取到继承仓库的model类

	public function makeModel()
    {
	//	dd($this->app);
		//dd($this->model());
        $model = $this->app->make($this->model()); //获取model 的实例   这种写法就相当于在框架中new了一下model
		//dd($model);

		//判断是否继承laravel 的Model
        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        return $this->model = $model;
    }

	/**
	* Retrieve all data of repository
	*
	* @param array $columns
	*
	* @return mixed
	*/
	public function all($columns = ['*']){
		return $this->model->all($columns);
	}
	/**
	* Find data by id
	*
	* @param       $id
	* @param array $columns
	*
	* @return mixed
	*/
	public function find($id, $columns = ['*']){
		return $this->model->select($columns)->find($id);
	}
	/**
	* Find data by field and value
	*
	* @param       $field
	* @param       $value
	* @param array $columns
	*
	* @return mixed
	*/
	public function findByField($field, $value, $columns = ['*']){
		return $this->model->select($columns)->where($field,$value)->get();
	}
	/**
	* Find data by multiple fields
	*
	* @param array $where
	* @param array $columns
	*
	* @return mixed
	*/
	public function findWhere(array $where, $columns = ['*']){

	}
	/**
	* Find data by multiple values in one field
	*
	* @param       $field
	* @param array $values
	* @param array $columns
	*
	* @return mixed
	*/
	public function findWhereIn($field, array $values, $columns = ['*']){

	}
	/**
	* Save a new entity in repository
	*
	* @param array $attributes
	*
	* @return mixed
	*/
	public function create(array $attributes){
		$model = new $this->model;
		return $model->fill($attributes)->save();
		//fill 过滤(只留下数组中的字段)  【 是根据 models 中 $fillable 中的字段】  不生明的话 全部都会被过滤
		//这个fill 必须要new 一下 不能用静态模式
	}
	/**
	* Update a entity in repository by id
	*
	* @param array $attributes
	* @param       $id
	*
	* @return mixed
	*/
	public function update(array $attributes, $id){

	}
	/**
	* Update or Create an entity in repository
	*
	* @throws ValidatorException
	*
	* @param array $attributes
	* @param array $values
	*
	* @return mixed
	*/
	public function updateOrCreate(array $attributes, array $values = []){

	}
	/**
	* Delete a entity in repository by id
	*
	* @param $id
	*
	* @return int
	*/
	public function delete($id){

	}
	/**
	* Order collection by a given column
	*
	* @param string $column
	* @param string $direction
	*
	* @return $this
	*/
	public function orderBy($column, $direction = 'asc'){

	}
	/**
	* Load relations
	*
	* @param $relations
	*
	* @return $this
	*/
	public function with($relations){

	}


    
}