<?php
namespace App\Repositories\Eloquent;
use App\Models\Account;
use App\Models\Game;
use App\Repositories\Eloquent\Repository;
use App\Models\AccountRole;
use Illuminate\Support\Facades\Cache;

class AccountRoleRepository extends Repository
{
	
	public function model()
	{
		return AccountRole::class;
	}

	/**
	 * 初始化用户
	 * return []
	 */
	public function initrole($attributes)
	{
		//dd($attributes);
		//验证字段必填
		$msg = $this->checkAttr('openid,rid',$attributes);
		if(!empty($msg)){
			$msg=['code'=>$msg];
			return $msg;
		}

		$game = Game::where('appid',$attributes['appid'])->first();

		if(is_null($game)){
			return ['code'=>trans('homenotice.appid')];
		}
		//判断是否存在openid
		$result = $this->findWhere(['openid'=>$attributes['openid'],'rid'=>$attributes['rid'],'gid'=>$game['id']])->first();
		//dd($result);
		if(!is_null($result)){
			//更新 上线时间和下线时间   写个接口处理 下线
			$data['login_time']=time();
			$data['leave_time']=time();
			$account_role = $result->update($data);//用对象调用
			if($account_role){
				return ['code'=>'200','msg'=>'save'];
			}

		}else{
			//如果为空集   创建新的角色
			$account = Account::where('openid',$attributes['openid'])->first();
			$attributes['register_time']=time();
			$attributes['aid'] = $account->id;
			$attributes['area_id'] = $account->create_of_area;
			$attributes['cid'] = $account->cid;
			$attributes['world'] = $account->world;
			$attributes['gid']=$game->id;
			$attributes['login_time']=time();
			$attributes['leave_time']=time();
			//dd($attributes);
			if($this->create($attributes)){
				return ['code'=>'200','msg'=>'create'];
			}
		}
	}

	public function ajaxBasedataRoles($appid)
	{
		//dd(request()->all());

		// datatables请求次数
		$draw = request('draw', 1);
		// 开始条数
		$start = request('start',config('admin.global.list.start'));
		// 每页显示数目
		$length = request('length',config('admin.global.list.length'));
//dd($length);
		// 排序
		$order['name'] = request('columns.' .request('order.0.column',0) . '.name');

		//dd($order['name']);字段名称
		$order['dir'] = request('order.0.dir','asc');
		//dd($order['dir']);asc  desc
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
		//dd($this->model);
		$roles = $this->model->where(['gid'=>$game->id])->get();
		$account_roles = $roles->groupBy('area_id')->take($length)->toArray();

		$collection = [];
		foreach($account_roles as $k => $v){
			$collection[$k]['area_id'] = $v[0]['area_id'];
			$collection[$k]['new_exp'] =100;
			$collection[$k]['account_num'] = $this->_getAllAccountNum($v[0]['area_id']);
			$collection[$k]['regs_rate'] = 99;
			$collection[$k]['role_num'] = $this->_getAllRoleNum($v[0]['area_id']);
			$collection[$k]['regs_role_rate'] = 99;
			$collection[$k]['hero_one'] = $this->_hasHeroNum(1,$v[0]['area_id']);
			$collection[$k]['hero_one_rate'] = 100*sprintf("%.4f",($this->_getAllRoleNum($v[0]['area_id']))?$this->_hasHeroNum(1,$v[0]['area_id'])/$this->_getAllRoleNum($v[0]['area_id']):0);
			$collection[$k]['hero_two'] = $this->_hasHeroNum(2,$v[0]['area_id']);
			$collection[$k]['hero_two_rate'] =100*sprintf("%.4f",($this->_getAllRoleNum($v[0]['area_id']))?$this->_hasHeroNum(2,$v[0]['area_id'])/$this->_getAllRoleNum($v[0]['area_id']):0);;
			$collection[$k]['hero_three'] = $this->_hasHeroNum(3,$v[0]['area_id']);
			$collection[$k]['hero_three_rate'] = 100*sprintf("%.4f",($this->_getAllRoleNum($v[0]['area_id']))?$this->_hasHeroNum(3,$v[0]['area_id'])/$this->_getAllRoleNum($v[0]['area_id']):0);;
			$collection[$k]['hero_four'] = $this->_hasHeroNum(4,$v[0]['area_id']);
			$collection[$k]['hero_four_rate'] = 100*sprintf("%.4f",($this->_getAllRoleNum($v[0]['area_id']))?$this->_hasHeroNum(4,$v[0]['area_id'])/$this->_getAllRoleNum($v[0]['area_id']):0);;
			$collection[$k]['hero_five'] = $this->_hasHeroNum(5,$v[0]['area_id']);
			$collection[$k]['hero_five_rate'] = 100*sprintf("%.4f",($this->_getAllRoleNum($v[0]['area_id']))?$this->_hasHeroNum(5,$v[0]['area_id'])/$this->_getAllRoleNum($v[0]['area_id']):0);;
			$collection[$k]['hero_six'] = $this->_hasHeroNum(6,$v[0]['area_id']);
			$collection[$k]['hero_six_rate'] = 100*sprintf("%.4f",($this->_getAllRoleNum($v[0]['area_id']))?$this->_hasHeroNum(6,$v[0]['area_id'])/$this->_getAllRoleNum($v[0]['area_id']):0);;

		}

		foreach($collection as $k =>$v){
			$num1[$k]=$v[$order['name']];
		}
		switch($order['dir']){
			case 'asc':
				array_multisort($num1, SORT_ASC, $collection);
				break;
			case 'desc':
				array_multisort($num1, SORT_DESC, $collection);
				break;
		}
		//dd(SORT_DESC);
		//array_multisort($num1, SORT_ASC, $num2, SORT_DESC, $arr);
		//array_multisort($num1, $sorttype, $collection);
		//dd($collection);




		$count = count($collection);

		//datatables固定返回格式
		return [
			'draw' => $draw,
			'recordsTotal' => $count,
			'recordsFiltered' => $count,
			'data' => $collection
		];
	}

	private  function _getAllAccountNum($create_of_area){
		//后期改成 每次查询  写一次缓存 后面的就读缓存
		return Account::where(['create_of_area'=>$create_of_area])->count();
//		$account = Cache::get(config('admin.globals.cache.account'));

//		return $account->where('create_of_area',$create_of_area)->count();
	}
	private  function _getAllRoleNum($area_id){
		return AccountRole::where(['area_id'=>$area_id])->count();
//		$account_roles = Cache::get(config('admin.globals.cache.account_role'));
//		return $account_roles->where('area_id',$area_id)->count();
	}
	private function _hasHeroNum($num,$area_id){
		return AccountRole::where(['area_id'=>$area_id])->where('has_heros_num',$num)->count();
//		$account_roles = Cache::get(config('admin.globals.cache.account_role'));
//		return $account_roles->where('has_heros_num',$num)->where('area_id',$area_id)->count();
	}

}