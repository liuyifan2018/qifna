<?php
/**
 * All my injuries are my medals
 * @author <liuyifan@915458370.email>
 * @Date: 2019/11/30 15:06
 */

namespace app\my\service;

use app\my\model\User;

class Data
{

	/**
	 * 获取个人信息
	 *
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 *
	 * @author liuyifan
	 * @createTime 2019/11/30 15:08
	 */
	public function userInfo() {
		$userInfo = User::where('id', '=', '1')->find();
		return $userInfo;
	}
}