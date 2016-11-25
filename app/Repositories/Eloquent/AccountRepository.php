<?php
namespace App\Repositories\Eloquent;
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
	 */
	public function inituser($attributes)
	{
		$attributes['register_time']=time();
		//dd($attributes);
		//判断是否存在openid
		$result = $this->findByField('openid',$attributes['openid'])->toArray();
		//dd($result);
		if($result){
			return $result;
		}else{
			return $this->create($attributes);
		}
	}




}