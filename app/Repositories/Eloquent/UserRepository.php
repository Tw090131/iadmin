<?php
namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Repository;
use App\Models\User;
class UserRepository extends Repository
{
	
	public function model()
	{
		return User::class;
	}
	/**
	 * 添加用户
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

	    $user = $this->model;

	    // 搜索框中的值
	    if ($search['value']) {
	        if($search['regex'] == 'true'){
	            $permission = $user->where('name', 'like', "%{$search['value']}%")->orWhere('name','like', "%{$search['value']}%");
	        }else{
	            $permission = $user->where('name', $search['value'])->orWhere('name', $search['value']);
	        }
	    }

	    $count = $user->count();

	    $user = $user->orderBy($order['name'], $order['dir']);
    	$user = $user->offset($start)->limit($length)->get();

		if ($user) {
			foreach ($user as &$v) {
				//dd( $v->getActionButtonAttribute());
				$v['actionButton'] = $v->getActionButtonAttribute();
			}
		}
		//dd($permissions);
    	//datatables固定返回格式
    	return [
	        'draw' => $draw,
	        'recordsTotal' => $count,
	        'recordsFiltered' => $count,
	        'data' => $user
	    ];
	}

	/**
	 * 修改视图
	 * @author 晚黎
	 * @date   2016-04-12T16:48:46+0800
	 * @param  [type]                   $id [description]
	 * @return [type]                       [description]
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
}