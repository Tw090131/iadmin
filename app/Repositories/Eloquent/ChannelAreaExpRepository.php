<?php
namespace App\Repositories\Eloquent;
use App\Models\Game;
use App\Models\Account;
use App\Models\AccountRole;
use App\Models\System;
use App\Repositories\Eloquent\Repository;
use App\Models\Channel_area_exp;
use Illuminate\Support\Facades\DB;

class ChannelAreaExpRepository extends Repository
{
	
	public function model()
	{
		return Channel_area_exp::class;
	}

	//处理埋点  判断area_id
	public function addMaidian($attr){

		$world = isset($attr['world'])?$attr['world']:'0';
		$attr['world']=$world;
		$msg = $this->checkAttr('appid,openid,cid,area_id,type',$attr);

		if(!empty($msg)){
			$msg=['code'=>$msg];
			return ($msg);
		}

		$account = Account::where(['openid'=>$attr['openid'],'cid'=>$attr['cid'],'world'=>$world,'create_of_area'=>$attr['area_id']])->first();
		$expinfo = Channel_area_exp::where(['appid'=>$attr['appid'],'cid'=>$attr['cid'],'area_id'=>$attr['area_id'],'world'=>$world])->first();
//		dd($expinfo);
		if(is_null($expinfo)){
			$this->create(['appid'=>$attr['appid'],'cid'=>$attr['cid'],'area_id'=>$attr['area_id'],'world'=>$world]);
			$expinfo = Channel_area_exp::where(['appid'=>$attr['appid'],'cid'=>$attr['cid'],'area_id'=>$attr['area_id'],'world'=>$world])->first();
		}
//dd($attr['type']);
		switch($attr['type']){
			case '1'://导入量

				//新增单渠道单区服总导入量  总量就相加
				$this->_getAllExp($account,$expinfo);
				break;
			case '2'://帐号埋点
				return $this->_initaccount($attr,$expinfo);
				break;
			case '3'://角色埋点

				//用于统计 新增账号数 和 滚服数的
				if(!isset($attr['rid'])){
					return ['code'=>trans('homenotice.rid')];
				}
				return $this->_roleMaidianHandle($account,$expinfo,$attr);
				break;
			case '4'://进入游戏埋点
				$this->_enterGameNum($expinfo);
				break;
		}
//		$system = System::where('appid',$attr['appid'])->first();
//		if(is_null($system)){
//			$this->create(['appid'=>$attr['appid'],'date'=>date('Ymd')]);
//			$system = System::where('appid',$attr['appid'])->first();
//		}
//		$str = config('admin.clickcount.'.$attr['type']);
//
//		$this->update([$str => $system-> $str + 1,'index_click_all'=>$system->index_click_all +1],$system->id);
//		return ['code'=>200];
	}

	//处理新增总导入量 （想法 一段时间的总导入量等于渠道区导入量）
	private function _getAllExp($account,$expinfo){
		if(is_null($account)){//只有新增帐号才算
			$this->update(['exp_num'=>$expinfo->exp_num +1],$expinfo->id);
		}else{
			echo 222;
		}
	}

	//角色 页面埋点  用于统计 新增账号数 和 滚服数的
	private function _roleMaidianHandle($account,$expinfo,$attr){
		$today = strtotime(date('Y-m-d', time()));//当天0点时间戳
		$res  = DB::table('account_role')->where(['openid'=>$attr['openid'],'area_id'=>$attr['area_id'],'cid'=>$attr['cid'],'world'=>$attr['world'],'rid'=>$attr['rid']])->first();
		if(!is_null($account)){//  判断 存在
			if($account->register_time > $today){//是否新帐号 注册时间是否大于今天0点
				if($this->_hasRole($account->openid)){//是否有角色
					//有角色   滚服
					if(is_null($res)){//已有此角色  不算滚服（作弊）
						if($this->update(['scroll_num'=>$expinfo->scroll_num +1],$expinfo->id)){
							return ['code'=>'200','msg'=>'gunfu'];
						}
					}else{
						$data['openid']=$account['openid'];
						$data['rid']=$attr['rid'];
						$data['aid']=$account['id'];
						$data['gid']=$account['gid'];
						$data['register_time']=time();
						$data['area_id']=$attr['area_id'];
						$data['cid']=$account['cid'];
						$data['world']=$account['world'];
						$data['login_time']=time();
						$data['leave_time']=time();
						$affected = DB::table('account_role')->insert($data);

						if($this->update(['scroll_num'=>$expinfo->scroll_num +1],$expinfo->id)){
							return ['code'=>'200','msg'=>'create_gunfu'];
						}
					}

				}else{
					//无角色  新增角色数
					$data['openid']=$account['openid'];
					$data['rid']=$attr['rid'];
					$data['aid']=$account['id'];
					$data['gid']=$account['gid'];
					$data['register_time']=time();
					$data['area_id']=$attr['area_id'];
					$data['cid']=$account['cid'];
					$data['world']=$account['world'];
					$data['login_time']=time();
					$data['leave_time']=time();
					$affected = DB::table('account_role')->insert($data);
					if($this->update(['new_role_num'=>$expinfo->new_role_num +1],$expinfo->id)){
						return ['code'=>'200','msg'=>'create'];
					}
				}
			}else{
				//滚服  如果是旧帐号  进入角色见面   肯定是滚服
				if(is_null($res)){//就账号  没角色  则插入角色 滚服+1
					$data['openid']=$account['openid'];
					$data['rid']=$attr['rid'];
					$data['aid']=$account['id'];
					$data['gid']=$account['gid'];
					$data['register_time']=time();
					$data['area_id']=$attr['area_id'];
					$data['cid']=$account['cid'];
					$data['world']=$account['world'];
					$data['login_time']=time();
					$data['leave_time']=time();
					$affected = DB::table('account_role')->insert($data);
					if($this->update(['scroll_num'=>$expinfo->scroll_num +1],$expinfo->id)){
						return ['code'=>'200','msg'=>'gunfu2'];
					}
				}else{//绝账号 有这个角色 （作弊）
					return ['code'=>'200','msg'=>'old_not_gunfu2'];
				}

			}
		}else{
			return ['code'=>'200','msg'=>'kong'];
		}
	}

	private function _enterGameNum($expinfo){

		$this->update(['enter_game_num'=>$expinfo->enter_game_num +1],$expinfo->id);
	}

	private function _initaccount($attributes,$expinfo){
		{

			$game = Game::where('appid',$attributes['appid'])->first();
			if(is_null($game)){
				return ['code'=>trans('homenotice.appid')];
			}

			//判断是否存在openid
			$result  = DB::table('account')->where(['openid'=>$attributes['openid'],'gid'=>$game->id,'cid'=>$attributes['area_id'],'cid'=>$attributes['cid'],'world'=>$attributes['world']])->first();
			if($result){
				//更新 上线时间和下线时间   写个接口处理 下线
				$data['login_time']=time();
				$data['leave_time']=time();
				$affected = $user = DB::table('account')->where('openid',$attributes['openid'])->update($data);
				if($affected){
					return ['code'=>'200','msg'=>'save'];
				}
			}else{
				$data['openid']=$attributes['openid'];
				$data['gid']=$game->id;
				$data['cid']=$attributes['cid'];
				$data['create_of_area']=$attributes['area_id'];
				$data['world']=$attributes['world'];
				$data['register_time']=time();
				$data['login_time']=time();
				$data['leave_time']=time();
				$affected = DB::table('account')->insert($data);
			//	dd($affected);
				if($affected){
					$this->update(['new_account_num'=>$expinfo->new_account_num +1],$expinfo->id);
					return ['code'=>'200','msg'=>'create'];
				}
			}
		}
	}

	private function _hasRole($openid){
		$res = AccountRole::where(['openid'=>$openid])->first();
		if(is_null($res)){
			return false;
		}else{
			return true;
		}
	}
}