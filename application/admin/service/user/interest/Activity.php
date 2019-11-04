<?php

namespace app\admin\service\user\interest;

use app\admin\model\Activity as ActivityModel;
use app\admin\traits\User;

/**
 * 用户活动
 * Class Activity
 * @package app\admin\service\user\interest
 */
class Activity
{


	/**
	 * 活动报名
	 * @param $data
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function signUp($data) {
		$userInfo = User::userInfo();
		if ($userInfo['status'] != 1 || $userInfo['money'] < 50) throw new \Exception('你无资格参加活动!');
		if (time() < strtotime(date("Y-m-d"), time()) + 86400 / 2) throw new \Exception('报名时间已结束!');
		if (empty($data['uid']) || $data['uid'] < 1) throw new \Exception('用户信息异常!');
		if (strlen($data['luck_id']) > 7) throw new \Exception('幸运号只能是6位!');
		$isSignUp = ActivityModel::where('uid', '=', $data['uid'])->find();
		if (empty($isSignUp)) throw new \Exception('你已报名,不能重复报名!');
		$data['create_time'] = time();
		$data['status'] = 1;
		ActivityModel::insert($data);
	}


}