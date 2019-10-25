<?php

namespace app\factory\service\user;

use app\factory\model\User;

/**
 * 用户奖励
 * Class Reward
 * @package app\factory\service\user
 */
class Reward
{

	/**
	 * 奖励金币
	 * @throws \think\Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function systemRewards(){
		$userList = User::where('status','=',1)->select();
		foreach ($userList as $k => $v){
			User::where('id','=',$v['id'])->setInc('money',50);
		}
		return true;
	}

	/**
	 * @param $id
	 * @param $val
	 * @return bool
	 * @throws \think\Exception
	 */
	public function userRewards($id,$val){
		if (empty($id) || $id < 1) return false;
		User::where('id','=',$id)->setInc('money',$val);
		return true;
	}

}