<?php
namespace App\Repositories\Eloquent;
use App\Models\AccountRole;
use App\Models\Channel_area_exp;
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
		//dd(is_null($appid));
		if(is_null($appid)){

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

//           用户帐号写入缓存()
			$accounts=Account::get();
			Cache::forever(config('admin.globals.cache.account'),$accounts);
//			用户角色写入缓存
			$account_roles=AccountRole::get();
			Cache::forever(config('admin.globals.cache.account_role'),$account_roles);
//			渠道区服导入量 写入缓存
			$exp_num = Channel_area_exp::get();
			Cache::forever(config('admin.globals.cache.exp_num'),$exp_num);

			//写入导入量缓存 重置 导入量
		//	DB::update('update iadmin_channel_area_exp set exp_num =0 , new_role_num=0 ,scroll_num=0,enter_game_num =0 where appid = ?', [$appid]);
			$lst=[];
		//	计算 专区
			//echo 'as',time(),"<br/>";
			$worlds = $this->_getAllWorld($game->id);//专区

			foreach($worlds as $key => $val){

				$world_channels = $this->_getAllChannels($game->id,$val);//渠道
				$world_areas = $this->_getAllAreas($game->id,$val);//区服

				$lst[] = $this->_calculation($val,$game,$today,1);//专区 的 全渠道 全区服

				foreach($world_channels as $k => $v){
				$lst[] = $this->_calculation($val,$game,$today,3,$v);//专区的 单渠道 全区服
					$tag = true;
					foreach($world_areas as $k2 => $v2){
						if($tag){
							$lst[] = $this->_calculation($val,$game,$today,2,0,$v2);//专区的全渠道 单区服
							$tag=false;
						}
						$lst[] = $this->_calculation($val,$game,$today,4,$v,$v2);//专区的单渠道 单区服
					}

				}
			}


			$channels = $this->_getAllChannels($game->id,'0');//渠道

			$areas = $this->_getAllAreas($game->id,'0');//区服

			$lst[] = $this->_calculation('0',$game,$today,1);//全渠道 全区服

			foreach($channels as $k => $v){
				$tag = true;
				$lst[] = $this->_calculation('0',$game,$today,3,$v);//单渠道 全区服
				foreach($areas as $k2 => $v2){
					if($tag){
						$lst[] = $this->_calculation('0',$game,$today,2,0,$v2);//全渠道 单区服
						$tag=false;
					}
					$lst[] = $this->_calculation('0',$game,$today,4,$v,$v2);//单渠道 单区服
				}
			}

		return $lst;
		}
		return false;
	}

	private function _calculation($world,$game,$today,$type,$cid=0,$area_id=0){
		/*1，算次留*/
		$lc=$this->_lcHandle([2,3,7,15,30,60,90],$today,$type,$cid,$area_id,$world,$game->id);
//		$lc3=$this->_lcHandle(3,$today,$type,$cid,$area_id,$world,$accounts_gid);
//		$lc7=$this->_lcHandle(7,$today,$type,$cid,$area_id,$world,$accounts_gid);
//		$lc15=$this->_lcHandle(15,$game->id,$today,$type,$cid,$area_id,$world);
//		$lc30=$this->_lcHandle(30,$game->id,$today,$type,$cid,$area_id,$world);
//		$lc60=$this->_lcHandle(60,$game->id,$today,$type,$cid,$area_id,$world);
//		$lc90=$this->_lcHandle(90,$game->id,$today,$type,$cid,$area_id,$world);

		$new_exp = $this->_getNewExp($game->appid,$cid,$area_id,$type,$world,'exp_num');//新增导入量

		$enter_game_num = $this->_getEnterGameNum($game->appid,$cid,$area_id,$type,$world,'enter_game_num');//新增进入游戏数
	//	$new_account_num = $this->_newAccountNum($game->appid,$cid,$area_id,$type,$world,'new_account_num');//新增帐号
	//	$new_role_num = $this->_newRoleNum($game->appid,$cid,$area_id,$type,$world,'new_role_num');//新增创角数
	//	$scroll_num = $this->_scrollNum($game->appid,$cid,$area_id,$type,$world,'scroll_num');//新增创角数
	//	$create_account_rate=$new_exp?$new_account_num/$new_exp:0;  这两个 暂时 用手动计算 没有啊写入数据库
	//	$create_role_rate = $new_exp?$new_role_num/$new_exp:0;

    //	$active_account_num = $this->_getactiveAccountNum($game->id,$today,$type,$cid,$area_id,$world);
	//	$active_role_num = $this->_getactiveRoleNum($game->id,$today,$type,$cid,$area_id,$world);
	//	$old_account_num =$this->_getOldAccountNum($game->id,$today,$type,$cid,$area_id,$world);
	//	$old_account_active_rate = $this->_getOldActiveRate($game->id,$today,$type,$cid,$area_id,$world);
		$attrs=[
			'type'=>$type,
			'gid'=>$game->id,
			'world'=>$world,
			'cid'=>$cid,
			'area_id'=>$area_id,
			'date'=>date('Ymd',time()-3600*24),
			'new_exp'=>$new_exp,
		//	'new_account_num'=>$new_account_num,
//		//	'create_account_rate'=>$create_account_rate,
		//	'new_role_num'=>$new_role_num,
			'enter_game_num'=>$enter_game_num,
//		//	'create_role_rate'=>$create_role_rate,
		//	'scroll_num'=>$scroll_num,
	  	//	 'active_account_num'=>$active_account_num,
		//	'active_role_num'=>$active_role_num,
			'lc2'=>$lc[0],
			'lc3'=>$lc[1],
			'lc7'=>$lc[2],
			'lc15'=>$lc[3],
			'lc30'=>$lc[4],
			'lc60'=>$lc[5],
			'lc90'=>$lc[6],
		//	'old_account_num'=>$old_account_num,
		//	'old_account_active_rate'=>$old_account_active_rate,
		];

		return $attrs;
	}

	//返回所有的专区
	private function _getAllWorld($gid){
		$filtered = Account::where(['gid'=>$gid])->pluck('world')->unique();
		return $filtered;
	}

	//返回游戏所有的渠道
	private function _getAllChannels($gid,$world = '0')
	{
		if($world=='0'){
			$filtered =  Account::where(['gid'=>$gid])->pluck('cid')->unique();
		}else{
			$filtered =  Account::where(['world'=>$world,'gid'=>$gid])->pluck('cid')->unique();
		}


		return $filtered;
	}

	//返回游戏所有的区服
	private function _getAllAreas($gid,$world ='0')
	{
	if($world=='0'){
		$filtered = Account::where(['gid'=>$gid])->pluck('create_of_area')->unique();
	}else{
		$filtered = Account::where(['world'=>$world,'gid'=>$gid])->pluck('create_of_area')->unique();
	}
		return $filtered;
	}

	//留存(次留)（次日留存 = 新增账号第2天登陆数/新增日注册账号数）
	private function _lcHandle($num,$today,$type,$cid,$area_id,$world,$gid){
		//新增帐号当天0点的时间戳
		//$starttime = $today-$num*24*3600;
	//	$accounts=$this->_getAccount($type,$cid,$area_id,$world,$gid);
		//dd($accounts->count());
		$arr=[];
		foreach($num as $k =>$v){
			$starttime = $today-$v*24*3600;
			switch($type){
				case 1:
					if($world == '0'){
						$fenzi = Account::where(['gid'=>$gid])->where('login_time','>',$today-3600*24)->where('register_time','>',$starttime)->where('register_time','<',$starttime+3600*24)->count();//全渠道全区服
						$fenmu = Account::where(['gid'=>$gid])->where('register_time','>',$starttime)->where('register_time','<',$starttime+3600*24)->count();//全渠道全区服
					}else{
						$fenzi = Account::where(['gid'=>$gid,'world'=>$world])->where('login_time','>',$today-3600*24)->where('register_time','>',$starttime)->where('register_time','<',$starttime+3600*24)->count();//全渠道全区服
						$fenmu = Account::where(['gid'=>$gid,'world'=>$world])->where('register_time','>',$starttime)->where('register_time','<',$starttime+3600*24)->count();//全渠道全区服
					}
					break;
				case 2:
					if($world == '0'){
						$fenzi = Account::where(['gid'=>$gid,'create_of_area'=>$area_id])->where('login_time','>',$today-3600*24)->where('register_time','>',$starttime)->where('register_time','<',$starttime+3600*24)->count();//全渠道全区服
						$fenmu = Account::where(['gid'=>$gid,'create_of_area'=>$area_id])->where('register_time','>',$starttime)->where('register_time','<',$starttime+3600*24)->count();//全渠道全区服
					}else{
						$fenzi = Account::where(['gid'=>$gid,'world'=>$world,'create_of_area'=>$area_id])->where('login_time','>',$today-3600*24)->where('register_time','>',$starttime)->where('register_time','<',$starttime+3600*24)->count();//全渠道全区服
						$fenmu = Account::where(['gid'=>$gid,'world'=>$world,'create_of_area'=>$area_id])->where('register_time','>',$starttime)->where('register_time','<',$starttime+3600*24)->count();//全渠道全区服
					}
					break;
				case 3:
					if($world == '0'){
						$fenzi = Account::where(['gid'=>$gid,'cid'=>$cid])->where('login_time','>',$today-3600*24)->where('register_time','>',$starttime)->where('register_time','<',$starttime+3600*24)->count();//全渠道全区服
						$fenmu = Account::where(['gid'=>$gid,'cid'=>$cid])->where('register_time','>',$starttime)->where('register_time','<',$starttime+3600*24)->count();//全渠道全区服
					}else{
						$fenzi = Account::where(['gid'=>$gid,'world'=>$world,'cid'=>$cid])->where('login_time','>',$today-3600*24)->where('register_time','>',$starttime)->where('register_time','<',$starttime+3600*24)->count();//全渠道全区服
						$fenmu = Account::where(['gid'=>$gid,'world'=>$world,'cid'=>$cid])->where('register_time','>',$starttime)->where('register_time','<',$starttime+3600*24)->count();//全渠道全区服
					}

					break;
				case 4:
					if($world == '0'){
						$fenzi = Account::where(['gid'=>$gid,'cid'=>$cid,'create_of_area'=>$area_id])->where('login_time','>',$today-3600*24)->where('register_time','>',$starttime)->where('register_time','<',$starttime+3600*24)->count();//全渠道全区服
						$fenmu = Account::where(['gid'=>$gid,'cid'=>$cid,'create_of_area'=>$area_id])->where('register_time','>',$starttime)->where('register_time','<',$starttime+3600*24)->count();//全渠道全区服
					}else{
						$fenzi = Account::where(['gid'=>$gid,'world'=>$world,'cid'=>$cid,'create_of_area'=>$area_id])->where('login_time','>',$today-3600*24)->where('register_time','>',$starttime)->where('register_time','<',$starttime+3600*24)->count();//全渠道全区服
						$fenmu = Account::where(['gid'=>$gid,'world'=>$world,'cid'=>$cid,'create_of_area'=>$area_id])->where('register_time','>',$starttime)->where('register_time','<',$starttime+3600*24)->count();//全渠道全区服
					}
					break;
			}
			if($fenmu==0){
				$res =0;
			}else{
				$res =100*($fenzi/$fenmu);
			}

			$arr[]=$res;
		}

//		echo "ww",time(),"<br/>";
//		$arr=[];
//		echo "ss",time(),"<br/>";
//		foreach($num as $k =>$v){
//			$starttime = $today-$v*24*3600;
//			$fenzi = $accounts->filter(function ($item) use($today,$starttime) {
//				if($item->login_time >= $today-3600*24 && $item->register_time>$starttime && $item->register_time < $starttime +3600*24){
//					return $item;
//				}
//			})->count();
//			$fenmu = $accounts->filter(function ($item) use($today,$starttime) {
//				if($item->register_time>$starttime && $item->register_time < $starttime +3600*24){
//					return $item;
//				}
//			})->count();
//
//			if($fenmu==0){
//				$res =0;
//			}else{
//				$res =100*($fenzi/$fenmu);
//			}
//
//			$arr[]=$res;
//		}
//		echo "ss",time(),"<br/>";
//		dd(333);
//		unset($accounts);

		return $arr;
	}

	//获取accounts
	private function _getAccount($type,$cid,$area_id,$world,$gid){
		switch($type){
			case 1:
				if($world == '0'){
					$accounts = Account::where(['gid'=>$gid])->get();//全渠道全区服
				}else{
					$accounts = Account::where(['gid'=>$gid,'world'=>$world])->get();//全渠道全区服
					//$accounts = $accounts_gid->where('world',$world);
				}
				break;
			case 2:
				if($world == '0'){
					$accounts = Account::where(['gid'=>$gid,'create_of_area'=>$area_id])->get();
					//$accounts =$accounts_gid->where('create_of_area',$area_id);//全渠道单区服
				}else{
					$accounts = Account::where(['gid'=>$gid,'world'=>$world,'create_of_area'=>$area_id])->get();
					//$accounts = $accounts_gid->where('world',$world)->where('create_of_area',$area_id);//全渠道单区服
				}
				break;
			case 3:
				if($world=='0'){
					$accounts = Account::where(['gid'=>$gid,'cid'=>$cid])->get();
					//$accounts = $accounts_gid->where('cid',$cid);//单渠道全区服
				}else{
					$accounts = Account::where(['gid'=>$gid,'world'=>$world,'cid'=>$cid])->get();
					//$accounts = $accounts_gid->where('cid',$cid)->where('world',$world);//单渠道全区服
				}
				break;
			case 4:
				if($world == '0'){
					$accounts = Account::where(['gid'=>$gid,'cid'=>$cid,'create_of_area'=>$area_id])->get();
					//$accounts = $accounts_gid->where('cid',$cid)->where('create_of_area',$area_id);//单渠道单区服
				}else{
					$accounts = Account::where(['gid'=>$gid,'world'=>$world,'cid'=>$cid,'create_of_area'=>$area_id])->get();
					//$accounts =$accounts_gid->where('cid',$cid)->where('create_of_area',$area_id)->where('world',$world);//单渠道单区服
				}
				break;
		}
		return $accounts;
	}

	private function _getAccountRole($gid,$type,$cid,$area_id,$world){
		switch($type){
			case 1:
				if($world=='0'){
					$account_roles = Cache::get(config('admin.globals.cache.account_role'))->where('gid',$gid);
				}else{
					$account_roles = Cache::get(config('admin.globals.cache.account_role'))->where('gid',$gid)->where('world',$world);
				}
				break;
			case 2:
				if($world == '0'){
					$account_roles = Cache::get(config('admin.globals.cache.account_role'))->where('gid',$gid)->where('area_id',$area_id);
				}else{
					$account_roles = Cache::get(config('admin.globals.cache.account_role'))->where('gid',$gid)->where('area_id',$area_id)->where('world',$world);
				}
				break;
			case 3:
				if($world == '0'){
					$account_roles = Cache::get(config('admin.globals.cache.account_role'))->where('gid',$gid)->where('cid',$cid);
				}else{
					$account_roles = Cache::get(config('admin.globals.cache.account_role'))->where('gid',$gid)->where('cid',$cid)->where('world',$world);
				}
				break;
			case 4:
				if($world == '0'){
					$account_roles = Cache::get(config('admin.globals.cache.account_role'))->where('gid',$gid)->where('cid',$cid)->where('area_id',$area_id);
				}else{
					$account_roles = Cache::get(config('admin.globals.cache.account_role'))->where('gid',$gid)->where('cid',$cid)->where('area_id',$area_id)->where('world',$world);
				}
				break;
		}
		return $account_roles;
	}

	//新增导入量
	private  function _getNewExp($appid,$cid,$area_id,$type,$world,$field){
		if($world == '0'){//不排除 专区
			switch($type){
				case 1://全渠道全区服
					$res = Channel_area_exp::where(['appid'=>$appid])->get();
//					$res = $exp_cache->filter(function ($item) use($appid,$cid,$area_id) {
//						if($item->appid == $appid){
//							return $item;
//						}
//					});
					break;
				case 2://全渠道单区服
					$res = Channel_area_exp::where(['appid'=>$appid,'area_id'=>$area_id])->get();
//					$res = $exp_cache->filter(function ($item) use($appid,$cid,$area_id) {
//						if($item->appid == $appid && $item->area_id == $area_id ){
//							return $item;
//						}
//					});
					break;
				case 3://单渠道全区服
					$res = Channel_area_exp::where(['appid'=>$appid,'cid'=>$cid])->get();
//					$res = $exp_cache->filter(function ($item) use($appid,$cid,$area_id) {
//						if($item->appid == $appid && $item->cid ==$cid ){
//							return $item;
//						}
//					});
					break;
				case 4://单渠道单区服
					$res = Channel_area_exp::where(['appid'=>$appid,'cid'=>$cid,'area_id'=>$area_id])->get();
//					$res = $exp_cache->filter(function ($item) use($appid,$cid,$area_id) {
//						if($item->appid == $appid && $item->cid == $cid && $item->area_id == $area_id ){
//							return $item;
//						}
//					});
					break;
			}
		}else{
			//专服
			switch($type){
				case 1://专服 全渠道全区服
					$res = Channel_area_exp::where(['appid'=>$appid,'world'=>$world])->get();
//					$res = $exp_cache->filter(function ($item) use($appid,$cid,$area_id,$world) {
//						if($item->appid == $appid && $item->world == $world){
//							return $item;
//						}
//					});

					break;
				case 2://全渠道单区服
					$res = Channel_area_exp::where(['appid'=>$appid,'area_id'=>$area_id,'world'=>$world])->get();
//					$res = $exp_cache->filter(function ($item) use($appid,$cid,$area_id,$world) {
//						if($item->appid == $appid && $item->area_id == $area_id && $item->world == $world){
//							return $item;
//						}
//					});

					break;
				case 3://单渠道全区服
					$res = Channel_area_exp::where(['appid'=>$appid,'cid'=>$cid,'world'=>$world])->get();
//					$res = $exp_cache->filter(function ($item) use($appid,$cid,$area_id,$world) {
//						if($item->appid == $appid && $item->cid ==$cid && $item->world == $world){
//							return $item;
//						}
//					});

					break;
				case 4://单渠道单区服
					$res = Channel_area_exp::where(['appid'=>$appid,'cid'=>$cid,'area_id'=>$area_id,'world'=>$world])->get();
//					$res = $exp_cache->filter(function ($item) use($appid,$cid,$area_id,$world) {
//						if($item->appid == $appid && $item->cid == $cid && $item->area_id == $area_id && $item->world == $world){
//							return $item;
//						}
//					});

					break;
			}
		}

		$filtered =  $res->pluck($field)->sum();

		return $filtered;
	}

	//新增进入游戏数

	//新增帐号
	private function _newAccountNum($appid,$cid,$area_id,$type,$world,$field){
		return $this->_getNewExp($appid,$cid,$area_id,$type,$world,$field);//新增帐号
	//	$accounts = Cache::get(config('admin.globals.cache.account'))->where('gid',$gid);
//		$accounts=$this->_getAccount($gid,$type,$cid,$area_id,$world);
//		$num = $accounts->filter(function ($item) use($today) {
//			if($item->register_time>$today-3600*24 && $item->register_time < $today)
//				return $item;
//		})->count();
//		//$num = Account::where(['gid'=>$gid])->whereBetween('register_time',[$today-3600*24,$today])->count();
//		unset($accounts);
//		return $num;
	}

	//新增角色数（老账号的不算！新帐号创建的角色）//感觉用埋点更好
	private function _newRoleNum($appid,$cid,$area_id,$type,$world,$field){
		return $this->_getNewExp($appid,$cid,$area_id,$type,$world,$field);//新增导入量
//		$accounts=$this->_getAccount($gid,$type,$cid,$area_id,$world);
//		$accounts = $accounts->filter(function ($item) use($today) {
//			if($item->register_time>$today-3600*24 && $item->register_time < $today)
//				return $item;
//		});
//
//		$arr = $accounts->toArray();
//		$account_roles=$this->_getAccountRole($gid,$type,$cid,$area_id,$world);
//		//$account_roles = AccountRole::where(['gid'=>$gid])->whereBetween('register_time',[$today-3600*24,$today])->get();
//
//		$account_roles = $account_roles->filter(function($item) use($arr){
//			foreach($arr as $k => $v){
//				if($item->openid == $v['openid']){
//					return $item;
//				}
//			}
//		});
//		//dd($account_roles->groupBy('openid')->count());
//		return $account_roles->groupBy('openid')->count();

	}

	//滚服数
	private  function _scrollNum($appid,$cid,$area_id,$type,$world,$field){
		return $this->_getNewExp($appid,$cid,$area_id,$type,$world,$field);//滚服数
	}

	//进入游戏数
	private  function  _getEnterGameNum($appid,$cid,$area_id,$type,$world,$field){
		return $this->_getNewExp($appid,$cid,$area_id,$type,$world,$field);//进入游戏数
	}

	//活跃账号数（当日新增帐号数+老帐号当日登陆数）
	private function _getactiveAccountNum($gid,$today,$type,$cid,$area_id,$world){
		//当日新增帐号数+老帐号当日登陆数
	//	$accounts=$this->_getAccount($gid,$type,$cid,$area_id,$world);
//		$num = $accounts->filter(function ($item) use($today) {
//			if($item->register_time>$today-3600*24 && $item->register_time < $today)
//				return $item;
//		})->count();//新增账号数

		$num = Account::where(['gid'=>$gid])->whereBetween('register_time',[$today-3600*24,$today])->count();//新增
//		$num2 = $accounts->filter(function ($item) use($today) {
//			if($item->register_time>0 && $item->register_time < $today-3600*24 && $item->login_time > $today-3600*24)//老帐号当日登陆数
//				return $item;
//		})->count();
		$num2 = Account::where(['gid'=>$gid])->whereBetween('register_time',[0,$today-3600*24])->where('login_time','>',$today-3600*24)->count();//老帐号当日登陆数
		//unset($accounts);
		return $num+$num2;
	}


	//老账号活跃趋势 = （今天老账号登陆数-前一天老账号登陆数）/前一天老账号登陆数*100%
	private function _getOldActiveRate($gid,$today,$type,$cid,$area_id,$world)
	{
	//	$accounts = $this->_getAccount($gid,$type,$cid,$area_id,$world);
		//前一天老帐号登陆数
		$num = Account::where(['gid'=>$gid])->whereBetween('register_time',[0,$today-3600*24])->whereBetween('login_time',[$today-3600*24*2,$today-3600*24])->count();//老帐号当日登陆数
//		$num = $accounts->filter(function ($item) use($today) {
//			if($item->register_time>0 && $item->register_time < $today-3600*24 && $item->login_time > $today-3600*24*2 && $item->login_time<$today-3600*24)
//				return $item;
//		})->count();

		//今天老帐号登陆数
//		$num2 = $accounts->filter(function ($item) use($today) {
//			if($item->register_time>0 && $item->register_time < $today-3600*24 && $item->login_time > $today-3600*24)
//				return $item;
//		})->count();
		$num2 = Account::where(['gid'=>$gid])->whereBetween('register_time',[0,$today-3600*24])->where('login_time','>',$today-3600*24)->count();//老帐号当日登陆数
		//unset($accounts);
		return $num?100*(($num2-$num)/$num):0;
	}

	//老账号数
	private function _getOldAccountNum($gid,$today,$type,$cid,$area_id,$world)
	{

//		$accounts=$this->_getAccount($gid,$type,$cid,$area_id,$world);
//		$num = $accounts->filter(function ($item) use($today) {
//			if( $item->register_time < $today-3600*24)
//				return $item;
//		})->count();
//		unset($accounts);
		$num = Account::where(['gid'=>$gid])->whereBetween('register_time',[0,$today-3600*24])->count();//老帐号数
		return $num;
	}

	//活跃角色数(当日新增角色数+老角色当日登陆数)
	private function _getactiveRoleNum($gid,$today,$type,$cid,$area_id,$world){
		//$account_roles = $this->_getAccountRole($gid,$type,$cid,$area_id,$world);
//		$num = $account_roles->filter(function ($item) use($today) {//新增
//			if( $item->register_time > $today-3600*24 && $item->register_time <$today)
//				return $item;
//		})->count();
		$num = AccountRole::where(['gid'=>$gid])->whereBetween('register_time',[$today-3600*24,$today])->count();//老帐号当日登陆数
//		$num2 = $account_roles->filter(function ($item) use($today) {//老角色当日登陆数
//			if( $item->register_time > 0  && $item->register_time < $today-3600*24 && $item->login_time >$today-3600*24)
//				return $item;
//		})->count();
		$num2 = AccountRole::where(['gid'=>$gid])->whereBetween('register_time',[0,$today-3600*24])->where('login_time','>',$today-3600*24)->count();//老帐号当日登陆数
		//unset($accounts);
		return $num+$num2;
	}


}