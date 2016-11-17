<?php
namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Repository;
use App\Models\Role;
use Flash;
class RoleRepository extends Repository
{
	
	public function model()
	{
		return Role::class;
	}
	/**
	 * 添加角色
	 * @author 晚黎
	 * @date   2016-10-21
	 * @param  [type]     $attributes [description]
	 * @return [type]                 [description]
	 */
	public function createRole($attributes)
	{
		$result = $this->create($attributes);
		if ($result) {
			flash('添加角色成功');
		}else{
			flash('添加角色失败','error');
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

	    $role = $this->model;

	    // 搜索框中的值
	    if ($search['value']) {
	        if($search['regex'] == 'true'){
	            $role = $role->where('name', 'like', "%{$search['value']}%")->orWhere('display_name','like', "%{$search['value']}%");
	        }else{
	            $role = $role->where('name', $search['value'])->orWhere('display_name', $search['value']);
	        }
	    }

	    $count = $role->count();

	    $role = $role->orderBy($order['name'], $order['dir']);
    	$roles = $role->offset($start)->limit($length)->get();

		if ($roles) {
			foreach ($roles as &$v) {
				//dd( $v->getActionButtonAttribute());
				$v['actionButton'] = $v->getActionButtonAttribute(false);
			}
		}
		//dd($roles);
    	//datatables固定返回格式
    	return [
	        'draw' => $draw,
	        'recordsTotal' => $count,
	        'recordsFiltered' => $count,
	        'data' => $roles
	    ];
	}

	/**
	 * 修改视图
	 * @author 晚黎
	 * @date   2016-04-12T16:48:46+0800
	 * @param  [type]                   $id [description]
	 * @return [type]                       [description]
	 */
//	public static function edit($id)
//	{
//		$role = Role::find($id);
//	//	dd($role->toArray());
//		if ($role) {
//			return $role;
//		}
//		abort(404);
//	}
	public function edit($id)
	{

		$role = Role::with('permission')->find($id);
		//dd($role);
		if ($role) {
			$roleArray = $role->toArray();
			//dd($roleArray);
			if ($roleArray['permission']) {
				$roleArray['permission'] = array_column($roleArray['permission'],'id');
			}
			//dd($roleArray);
			return $roleArray;
		}
		abort(404);
	}


	/**
	 * 修改角色

	 */
//	public function updateRole($request)
//	{
//		$role = $this->model->find($request->id);
//		if ($role) {
//
//			$isUpdate = $role->update($request->all());//update 自带填充 只要模型定义fillable就可以了
//			if ($isUpdate) {
//				flash('修改角色成功', 'success');
//				return true;
//			}
//			flash('修改角色失败', 'error');
//			return false;
//		}
//		abort(404,'角色数据找不到');//  404----找到views/errors/404.blade.php
//	}
	public function updateRole($request,$id)
	{
		$role = $this->model->find($id);

		if ($role) {
			if ($role->fill($request->all())->save()) {
				//自动更新角色权限关系
				if ($request->permission) {
					$role->permission()->sync($request->permission);
				}
				flash(trans('alerts.roles.updated_success'),'success');
				return true;
			}
			flash(trans('alerts.roles.updated_error'),'error');
			return false;
		}
		abort(404);
	}

	/**
	 * 添加角色
	 * @author 晚黎
	 * @date   2016-04-13T11:50:22+0800
	 * @param  [type]                   $request [description]
	 * @return [type]                            [description]
	 */
	public function store($request)
	{
		$role = new Role;
		if ($role->fill($request->all())->save()) {
			//自动更新角色权限关系
			if ($request->permission) {//数组中的permission字段
				$role->permission()->sync($request->permission);
			}
			flash(trans('alerts.roles.created_success'), 'success');
			//Flash::success();
			return true;
		}
		flash(trans('alerts.roles.created_success'),'error');
		//Flash::error(trans('alerts.roles.created_error'));
		return false;
	}

	public function show($id)
	{

		$role = Role::find($id)->permission;
		$array = [];
		if ($role) {
			foreach ($role as $v) {
				array_set($array, $v->name, ['name' => $v->name,'desc' => $v->description,'display_name' => $v->display_name]);
			}
		}
		//dd($array);
		return $array;
	}

	public function destroy($id)
	{
		$isDelete = Role::destroy($id);
		if ($isDelete) {

			flash(trans('alerts.roles.deleted_success'),'success');
			//Flash::success();
			return true;
		}
		flash(trans('alerts.roles.deleted_error'),'error');
		//Flash::error();
		return false;
	}
}