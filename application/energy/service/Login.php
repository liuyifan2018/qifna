<?php

namespace app\energy\service;

use app\energy\traits\OutPut;
use app\energy\common\Date;
use app\energy\model\UserModel;

class Login{
	use OutPut;

	/**
	 * @param $data
	 * @return mixed
	 * @throws \Exception
	 * 用户授权获取信息
	 */
	public static function wxLogin($data) {
		$userInfo = UserModel::where('openid','=',$data['openId'])->find();
		if (empty($userInfo)) {
			$msg['create_time'] = Date::getNowTime();
			UserModel::insert($msg);
		}
		return $userInfo;
	}
}