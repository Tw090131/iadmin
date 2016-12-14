<?php
namespace App\Repositories\Eloquent;
use App\Models\AccountRole;
use App\Models\Dailydata;
use App\Models\Game;
use App\Models\Account;
use App\Models\System;
use App\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SystemRepository extends Repository
{
	
	public function model()
	{
		return System::class;
	}

	/**
	 * 统计日常
	 * return []
	 */
	public function dailyStatistic($appid){
		if(empty($appid)){
			return ['code'=>trans('homenotice.appid')];
		}

		$game = Game::where('appid',$appid)->first();

		if(is_null($game)){
			return ['code'=>trans('homenotice.appid')];
		}

		$today_date = date('Ymd',time());

		$today = strtotime(date('Y-m-d', time()));//当天0点时间戳

	 	$system = System::where('appid',$appid)->first();

		if(is_null($system)){
			$this->create(['appid'=>$appid,'date'=>$today_date]);
			$system = System::where('appid',$appid)->first();
		}
		if($today_date != $system->date){
			//先更新日期 然后统计以下内容
			$system->update(['date'=>date('Ymd')]);

           //用户帐号写入缓存()
			$accounts=Account::get();
			Cache::forever(config('admin.globals.cache.account'),$accounts);
			//用户角色写入缓存
			$account_roles=AccountRole::get();
			Cache::forever(config('admin.globals.cache.account_role'),$account_roles);

			$channels = $this->_getAllChannels($game->id,$today);
			$areas = $this->_getAllAreas($game->id,$today);
			$lst=[];
			$lst[] = $this->_calculation($system,$game,$today,1);//全渠道 全区服
			foreach($channels as $k => $v){
				$lst[] = $this->_calculation($system,$game,$today,3,$v);//单渠道 全区服
				foreach($areas as $k2 => $v2){
					$lst[] = $this->_calculation($system,$game,$today,2,0,$v2);//全渠道 单区服
					$lst[] = $this->_calculation($system,$game,$today,4,$v,$v2);//单渠道 单区服
				}
			}
		return $lst;
		}
		return false;
	}

	private function _calculation($system,$game,$today,$type,$cid=0,$area_id=0){
		/*1，算次留*/
		$lc2=$this->_lcHandle(2,$game->id,$today,$type,$cid,$area_id);
		$lc3=$this->_lcHandle(3,$game->id,$today,$type,$cid,$area_id);
		$lc7=$this->_lcHandle(7,$game->id,$today,$type,$cid,$area_id);
		$lc15=$this->_lcHandle(15,$game->id,$today,$type,$cid,$area_id);
		$lc30=$this->_lcHandle(30,$game->id,$today,$type,$cid,$area_id);
		$lc60=$this->_lcHandle(60,$game->id,$today,$type,$cid,$area_id);
		$lc90=$this->_lcHandle(90,$game->id,$today,$type,$cid,$area_id);
//		--------------------
	//	$new_exp = $this->_getIndexClick($system,$game->id);//新增导入量
		$new_account_num = $this->_newAccountNum($game->id,$today,$type,$cid,$area_id);//新增帐号
		$new_role_num = $this->_newRoleNum($game->id,$today,$type,$cid,$area_id);//新增创角数
	//	$create_account_rate=$new_exp?$new_account_num/$new_exp:0;
	//	$create_role_rate = $new_exp?$new_role_num/$new_exp:0;

		$active_account_num = $this->_getactiveAccountNum($game->id,$today,$type,$cid,$area_id);
	//	$active_role_num = $this->_getactiveRoleNum($game->id,$today);
		$old_account_num =$this->_getOldAccountNum($game->id,$today,$type,$cid,$area_id);//改
	//	$old_account_active_rate = $this->_getOldActiveRate($game->id,$today);
		$attrs=[
			'type'=>$type,
			'gid'=>$game->id,
			'cid'=>$cid,
			'area_id'=>$area_id,
			'date'=>date('Ymd',time()-3600*24),
		//	'new_exp'=>$new_exp,
			'new_account_num'=>$new_account_num,
		//	'create_account_rate'=>$create_account_rate,
			'new_role_num'=>$new_role_num,
		//	'create_role_rate'=>$create_role_rate,
			'active_account_num'=>$active_account_num,
		//	'active_role_num'=>$active_role_num,
			'lc2'=>$lc2,
			'lc3'=>$lc3,
			'lc7'=>$lc7,
			'lc15'=>$lc15,
			'lc30'=>$lc30,
			'lc60'=>$lc60,
			'lc90'=>$lc90,
			'old_account_num'=>$old_account_num,
		//	'old_account_active_rate'=>$old_account_active_rate,
		];
		return $attrs;
	}

	//返回游戏所有的渠道
	private function _getAllChannels($gid,$today)
	{
		$accounts = Cache::get(config('admin.globals.cache.account'))->where('gid',$gid)->groupBy('cid')->toArray();
		$arrs = [];
		foreach($accounts as $k => $v){
			$arrs[]=$v[0]['cid'];
		}
		return $arrs;
	}

	//返回游戏所有的区服
	private function _getAllAreas($gid,$today)
	{
		$accounts = Cache::get(config('admin.globals.cache.account'))->where('gid',$gid)->groupBy('create_of_area')->toArray();
		$arrs = [];
		foreach($accounts as $k => $v){
			$arrs[]=$v[0]['create_of_area'];
		}
		return $arrs;
	}

	//留存(次留)（次日留存 = 新增账号第2天登陆数/新增日注册账号数）(改)
	private function _lcHandle($num,$gid,$today,$type,$cid,$area_id){
		//新增帐号当天0点的时间戳
		$starttime = $today-($num-1)*24*3600;
		$accounts=$this->_getAccount($gid,$type,$cid,$area_id);
		$fenzi = $accounts->filter(function ($item) use($today,$starttime) {
			if($item->login_time >= $today && $item->register_time>$starttime && $item->register_time < $starttime +3600*24)
			return $item;
		})->count();
		$fenmu = $accounts->filter(function ($item) use($today,$starttime) {
			if($item->register_time>$starttime && $item->register_time < $starttime +3600*24)
			return $item;
		})->count();
//		$fenzi = Account::where(['gid'=>$gid])->where('login_time','>=',$today)->whereBetween('register_time',[$starttime,$starttime+3600*24])->count();//分子
//		$fenmu = Account::where(['gid'=>$gid])->whereBetween('register_time',[$starttime,$starttime+3600*24])->count();


		if($fenmu==0){
			return 0;
		}
		return 100*($fenzi/$fenmu);
	}

	//获取accounts
	private function _getAccount($gid,$type,$cid,$area_id){
		switch($type){
			case 1:
				$accounts = Cache::get(config('admin.globals.cache.account'))->where('gid',$gid);//全渠道全区服
				break;
			case 2:
				$accounts = Cache::get(config('admin.globals.cache.account'))->where('gid',$gid)->where('cid',0)->where('create_of_area',$area_id);//全渠道单区服
				break;
			case 3:
				$accounts = Cache::get(config('admin.globals.cache.account'))->where('gid',$gid)->where('cid',$cid)->where('create_of_area',0);//单渠道全区服
				break;
			case 4:
				$accounts = Cache::get(config('admin.globals.cache.account'))->where('gid',$gid)->where('cid',$cid)->where('create_of_area',$area_id);//单渠道单区服
				break;
		}
		return $accounts;
	}

	private function _getAccountRole($gid,$type,$cid,$area_id){
		switch($type){
			case 1:
				$account_roles = Cache::get(config('admin.globals.cache.account_role'))->where('gid',$gid);
				break;
			case 2:
				$account_roles = Cache::get(config('admin.globals.cache.account_role'))->where('gid',$gid)->where('cid',0)->where('area_id',$area_id);
				break;
			case 3:
				$account_roles = Cache::get(config('admin.globals.cache.account_role'))->where('gid',$gid)->where('cid',$cid)->where('area_id',0);
				break;
			case 4:
				$account_roles = Cache::get(config('admin.globals.cache.account_role'))->where('gid',$gid)->where('cid',$cid)->where('area_id',$area_id);
				break;
		}
		return $account_roles;
	}

	//新增导入量
	private  function _getIndexClick($system,$gid){
		$str = config('admin.clickcount.1');
		$today_click= $system->$str;
		System::where(['appid'=>$system->appid])->update([$str=>0]);
		return $today_click;
	}

	//新增进入游戏数

	//新增帐号
	private function _newAccountNum($gid,$today,$type,$cid,$area_id){
	//	$accounts = Cache::get(config('admin.globals.cache.account'))->where('gid',$gid);
		$accounts=$this->_getAccount($gid,$type,$cid,$area_id);
		$num = $accounts->filter(function ($item) use($today) {
			if($item->register_time>$today-3600*24 && $item->register_time < $today)
				return $item;
		})->count();
		//$num = Account::where(['gid'=>$gid])->whereBetween('register_time',[$today-3600*24,$today])->count();
		return $num;
	}

	//新增角色数（老账号的不算！新帐号创建的角色）
	private function _newRoleNum($gid,$today,$type,$cid,$area_id){
		$accounts=$this->_getAccount($gid,$type,$cid,$area_id);
		$accounts = $accounts->filter(function ($item) use($today) {
			if($item->register_time>$today-3600*24 && $item->register_time < $today)
				return $item;
		});
		$account_roles=$this->_getAccountRole($gid,$type,$cid,$area_id);
		//$account_roles = AccountRole::where(['gid'=>$gid])->whereBetween('register_time',[$today-3600*24,$today])->get();

		$account_roles = $account_roles->filter(function($item) use($accounts){
			foreach($accounts as $k => $v){
				if($item->openid == $v['openid']){
					return $item;
				}
			}
		});
		return $account_roles->count();
	}

	//活跃账号数（当日新增帐号数+老帐号当日登陆数）
	private function _getactiveAccountNum($gid,$today,$type,$cid,$area_id){
		//当日新增帐号数+老帐号当日登陆数
		$accounts=$this->_getAccount($gid,$type,$cid,$area_id);
		$num = $accounts->filter(function ($item) use($today) {
			if($item->register_time>$today-3600*24 && $item->register_time < $today)
				return $item;
		})->count();//新增账号数
	//	$num = Account::where(['gid'=>$gid])->whereBetween('register_time',[$today-3600*24,$today])->count();//新增
		$num2 = $accounts->filter(function ($item) use($today) {
			if($item->register_time>0 && $item->register_time < $today-3600*24 && $item->login_time > $today-3600*24)//老帐号当日登陆数
				return $item;
		})->count();
	//	$num2 = Account::where(['gid'=>$gid])->whereBetween('register_time',[0,$today-3600*24])->where('login_time','>',$today-3600*24)->count();//老帐号当日登陆数
		return $num+$num2;
	}
	//老账号活跃趋势 = （今天老账号登陆数-前一天老账号登陆数）/前一天老账号登陆数*100%
	private function _getOldActiveRate($gid,$today)
	{
		$accounts = Cache::get(config('admin.globals.cache.account'))->where('gid',$gid);
		//前一天老帐号登陆数
		$num = $accounts->where('gid',$gid)->filter(function ($item) use($today) {
			if($item->register_time>0 && $item->register_time < $today-3600*24 && $item->login_time > $today-3600*24*2 && $item->login_time<$today-3600*24)
				return $item;
		})->count();
		//今天老帐号登陆数
		$num2 = $accounts->where('gid',$gid)->filter(function ($item) use($today) {
			if($item->register_time>0 && $item->register_time < $today-3600*24 && $item->login_time > $today-3600*24)
				return $item;
		})->count();
		return $num?100*(($num2-$num)/$num):0;
	}

	//老账号数
	private function _getOldAccountNum($gid,$today,$type,$cid,$area_id)
	{
		//当日新增帐号数+老帐号当日登陆数
		$accounts=$this->_getAccount($gid,$type,$cid,$area_id);
		$num = $accounts->filter(function ($item) use($today) {
			if( $item->register_time < $today-3600*24)
				return $item;
		})->count();
		return $num;
	}

	//活跃角色数(当日新增角色数+老角色当日登陆数)
	private function _getactiveRoleNum($gid,$today){
		$account_roles = Cache::get(config('admin.globals.cache.account_role'))->where('gid',$gid);
		$num = $account_roles->where('gid',$gid)->filter(function ($item) use($today) {
			if( $item->register_time > $today-3600*24 && $item->register_time <$today)
				return $item;
		})->count();
		//$num = AccountRole::where(['gid'=>$gid])->whereBetween('register_time',[$today-3600*24,$today])->count();//新增
		$num2 = $account_roles->where('gid',$gid)->filter(function ($item) use($today) {
			if( $item->register_time > 0  && $item->register_time < $today-3600*24 && $item->login_time >$today-3600*24)
				return $item;
		})->count();
		//$num2 = AccountRole::where(['gid'=>$gid])->whereBetween('register_time',[0,$today-3600*24])->where('login_time','>',$today-3600*24)->count();//老角色当日登陆数
		return $num+$num2;
	}

	//处理埋点  判断area_id
	public function addMaidian($attr){
		$msg = $this->checkAttr('appid,area_id,type',$attr);
		if(!empty($msg)){
			$msg=['code'=>$msg];
			return $msg;
		}
		$system = System::where('appid',$attr['appid'])->first();
		if(is_null($system)){
			$this->create(['appid'=>$attr['appid'],'date'=>date('Ymd')]);
			$system = System::where('appid',$attr['appid'])->first();
		}
		$str = config('admin.clickcount.'.$attr['type']);

		$this->update([$str => $system-> $str + 1,'index_click_all'=>$system->index_click_all +1],$system->id);
		return ['code'=>200];
	}
}