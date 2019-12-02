<?php
/**
 * All my injuries are my medals
 * @author <liuyifan@915458370.email>
 * @Date: 2019/12/2 15:41
 */

namespace app\my\service;

use app\my\model\User as UserModel;

class User
{

	/**
	 * @param $user
	 * @return true
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @throws \think\db\exception\DataNotFoundException
	 */
	public static function login($user) {
		$userInfo = UserModel::where('username', '=', $user['username'])->find();

		if (empty($userInfo)) throw new \Exception('用户不存在!');

		if ($userInfo['password'] != UserModel::isPassword($user['password'])) throw new \Exception('密码错误!');

		return true;
	}
}