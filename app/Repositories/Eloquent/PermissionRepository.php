<?php
namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Repository;
use App\Models\Permission;
class permissionRepository extends Repository
{
	
	public function model()
	{
		return Permission::class;
	}
	/**
	 * 添加权限
	 */
	public function createPermission($attributes)
	{
		$result = $this->create($attributes);
		if ($result) {
			flash('添加权限成功');
		}else{
			flash('添加权限失败','error');
		}
		return $result;
	}

	public function ajaxIndex()
	{
		//dd(request()->all());
		// datatables请求次数
    	$draw = request('draw', 1);
    	// 开始条数
		$start = request('start',config('admin.global.list.start'));
		// 每页显示数目
		$length = request('length',config('admin.global.list.length'));

		// 排序
	    $order['name'] = request('columns.' .request('order.0.column',0) . '.name');
	    $order['dir'] = request('order.0.dir','asc');

	    $search['value'] = request('search.value','');

	    $search['regex'] = request('search.regex',false);
	//	dd($search);
	    $permission = $this->model;

	    // 搜索框中的值
	    if ($search['value']) {
	        if($search['regex'] == 'true'){
	            $permission = $permission->where('name', 'like', "%{$search['value']}%")->orWhere('display_name','like', "%{$search['value']}%");
	        }else{
	            $permission = $permission->where('name', $search['value'])->orWhere('display_name', $search['value']);
	        }
	    }

	    $count = $permission->count();

	    $permission = $permission->orderBy($order['name'], $order['dir']);
    	$permissions = $permission->offset($start)->limit($length)->get();
		//dd($permissions);
		if ($permissions) {
			foreach ($permissions as &$v) {

				//dd( $v->getActionButtonAttribute());
				$v['actionButton'] = $v->getActionButtonAttribute(); //每个$v 都是 permissiion的对象  trait在模型中引入的 所以可以用
			}
		}
		//dd($permissions);
    	//datatables固定返回格式
    	return [
	        'draw' => $draw,
	        'recordsTotal' => $count,
	        'recordsFiltered' => $count,
	        'data' => $permissions
	    ];
	}

	/**
	 * 修改视图
	 */
	public static function edit($id)
	{
		$permission = Permission::find($id);
	//	dd($permission->toArray());
		if ($permission) {
			return $permission;
		}
		abort(404);
	}


	/**
	 * 修改权限

	 */
	public function updatePermission($request)
	{
		$perssion = $this->model->find($request->id);
		if ($perssion) {

			$isUpdate = $perssion->update($request->all());//update 自带填充 只要模型定义fillable就可以了
			if ($isUpdate) {
				flash('修改权限成功', 'success');
				return true;
			}
			flash('修改权限失败', 'error');
			return false;
		}
		abort(404,'权限数据找不到');//  404----找到views/errors/404.blade.php
	}


	public function findPermissionWithArray()
	{
		//$permission = Permission::where('status',config('admin.global.status.active'))->get();
		$permission = Permission::get();
		//dd($permission);
		$array = [];
		if ($permission) {
			//dd($permission->toArray());
			foreach ($permission as $v) {
				//admin.systems.manage 按点 拆分
				array_set($array, $v->name, ['id' => $v->id,'name' => $v->name,'display_name'=>$v->display_name,'desc' => $v->description,'key' => str_random(10)]);

				//dd($array);
			}
			//dd($array);
		}

		return $array;
	}
}