<?php
namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Repository;
use App\Models\Game;
class GameRepository extends Repository
{
	
	public function model()
	{
		return Game::class;
	}
	/**
	 * 添加游戏
	 */
	public function createGame($attributes)
	{
		$result = $this->create($attributes);
		if ($result) {
			flash('添加游戏成功');
		}else{
			flash('添加游戏失败','error');
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

	    $game = $this->model;

	    // 搜索框中的值
	    if ($search['value']) {
	        if($search['regex'] == 'true'){
	            $game = $game->where('name', 'like', "%{$search['value']}%")->orWhere('display_name','like', "%{$search['value']}%");
	        }else{
	            $game = $game->where('name', $search['value'])->orWhere('display_name', $search['value']);
	        }
	    }

	    $count = $game->where('cp_uid',auth()->user()->id)->count();

	    $game = $game->orderBy($order['name'], $order['dir']);
    	$games = $game->where('cp_uid',auth()->user()->id)->offset($start)->limit($length)->get();

		if ($games) {
			foreach ($games as &$v) {
				//dd( $v->getActionButtonAttribute());
				$v['actionButton'] = $v->getActionButtonAttribute();
			}
		}
		//dd($games);
    	//datatables固定返回格式
    	return [
	        'draw' => $draw,
	        'recordsTotal' => $count,
	        'recordsFiltered' => $count,
	        'data' => $games
	    ];
	}

	/**
	 * 修改视图
	 */
	public static function edit($id)
	{
		$game = Game::find($id);
	//	dd($game->toArray());
		if ($game) {
			return $game;
		}
		abort(404);
	}


	/**
	 * 修改游戏

	 */
	public function updateGame($request)
	{
		$perssion = $this->model->find($request->id);
		if ($perssion) {

			$isUpdate = $perssion->update($request->all());//update 自带填充 只要模型定义fillable就可以了
			if ($isUpdate) {
				flash('修改游戏成功', 'success');
				return true;
			}
			flash('修改游戏失败', 'error');
			return false;
		}
		abort(404,'游戏数据找不到');//  404----找到views/errors/404.blade.php
	}


	public function findGameWithArray()
	{
		//$game = Game::where('status',config('admin.global.status.active'))->get();
		$game = Game::get();
		//dd($game);
		$array = [];
		if ($game) {
			//dd($game->toArray());
			foreach ($game as $v) {
				//admin.systems.manage 按点 拆分
				array_set($array, $v->name, ['id' => $v->id,'name' => $v->name,'display_name'=>$v->display_name,'desc' => $v->description,'key' => str_random(10)]);

				//dd($array);
			}
			//dd($array);
		}

		return $array;
	}
}