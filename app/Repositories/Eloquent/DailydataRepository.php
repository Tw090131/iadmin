<?php
namespace App\Repositories\Eloquent;
use App\Models\Dailydata;
use App\Models\Game;
use App\Repositories\Eloquent\Repository;
class DailydataRepository extends Repository
{
	
	public function model()
	{
		return Dailydata::class;
	}


	public function  addDailydata($attrs){
		//先查下有无这条记录
		//dd($attrs);
			foreach($attrs as $k => $v){
				$res = Dailydata::where(['gid'=>$v['gid'],'world'=>$v['world'],'cid'=>$v['cid'],'area_id'=>$v['area_id'],'date'=>$v['date']])->first();
				if(is_null($res)) {
					$this->create($v);
				}
			}
	}


	public function ajaxRetentionIndex($appid)
	{

		// datatables请求次数
		$draw = request('draw', 1);
		// 开始条数
		$start = request('start',config('admin.global.list.start'));
		// 每页显示数目
		$length = request('length',config('admin.global.list.length'));
		$channel = request('channel',0);
		$area = request('area',0);
		$world =  request('world',0);
//		dump($channel);
//		dd($area);
		// 排序
		$order['name'] = request('columns.' .request('order.0.column',0) . '.name');
		$order['dir'] = request('order.0.dir','asc');

		$search['value'] = request('search.value','');

		$search['regex'] = request('search.regex',false);

		$retention = $this->model;

		// 搜索框中的值
		/*
		if ($search['value']) {
			if($search['regex'] == 'true'){
				$retention = $retention->where('name', 'like', "%{$search['value']}%")->orWhere('display_name','like', "%{$search['value']}%");
			}else{
				$permission = $permission->where('name', $search['value'])->orWhere('display_name', $search['value']);
			}
		}
		*/
		$game=Game::where('appid',$appid)->first();

		$count = $retention->where(['gid'=>$game->id,'cid'=>$channel,'area_id'=>$area,'world'=>$world])->count();

		$retention = $retention->orderBy($order['name'], $order['dir']);

		$retention = $retention->where(['gid'=>$game->id,'cid'=>$channel,'area_id'=>$area,'world'=>$world])->offset($start)->limit($length)->get()->toArray();
		foreach($retention as $k => $v){
			$retention[$k]['regs_rate']=100*sprintf("%.4f",($v['new_exp'])?$v['new_account_num']/$v['new_exp']:0);
			$retention[$k]['regs_role_rate']=100*sprintf("%.4f",($v['new_exp'])?$v['new_role_num']/$v['new_exp']:0);
			//dump($v);
		}
		//dd($retention);
	/*
			if ($retention) {
			foreach ($retention as &$v) {

				//dd( $v->getActionButtonAttribute());
				$v['actionButton'] = $v->getActionButtonAttribute(); //每个$v 都是 permissiion的对象  trait在模型中引入的 所以可以用
			}
		}
	*/
		//dd($permissions);
		//datatables固定返回格式
		return [
			'draw' => $draw,
			'recordsTotal' => $count,
			'recordsFiltered' => $count,
			'data' => $retention
		];
	}
}