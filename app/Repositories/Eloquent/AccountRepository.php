<?php
namespace App\Repositories\Eloquent;
use App\Models\Game;
use App\Repositories\Eloquent\Repository;
use App\Models\Account;
class AccountRepository extends Repository
{
	
	public function model()
	{
		return Account::class;
	}

	/**
	 * 初始化用户
	 * return []
	 */
	public function initaccount($attributes)
	{
		//验证字段必填
		$msg = $this->checkAttr('appid,openid,cid,create_of_area',$attributes);
		if(!empty($msg)){
			$msg=['code'=>$msg];
			return $msg;
		}

		$game = Game::where('appid',$attributes['appid'])->first();
		//dd($game);
		if(is_null($game)){
			return ['code'=>trans('homenotice.appid')];
		}

		//判断是否存在openid
		$result = $this->findWhere(['openid'=>$attributes['openid'],'gid'=>$game->id])->first();
		if($result){
		//	dd($result->id);
			//更新 上线时间和下线时间   写个接口处理 下线
			$data['login_time']=time();
			$data['leave_time']=time();
			$account = $result->update($data);//用对象调用
			if($account){
				return ['code'=>'200','msg'=>'save'];
			}
		}else{
			$attributes['register_time']=time();
			$attributes['login_time']=time();
			$attributes['leave_time']=time();
			$attributes['gid']=$game->id;
			if($this->create($attributes)){
				return ['code'=>'200','msg'=>'create'];
			}
		}
	}




}