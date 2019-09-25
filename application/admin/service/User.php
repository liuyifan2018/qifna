<?php

namespace app\admin\service;

use app\admin\CURD;
use app\admin\model\User as UserModel;
use app\admin\model\ULog as UserLog;
use think\Controller;
use app\admin\traits\User as UserTrait;
use think\Exception;
use app\admin\traits\Handle;

class User extends Controller{

	use CURD{
		valueSetInc as public;
	}
	/**
	 * 登录
	 *
	 * @param array $userInfo
	 * @return UserModel
	 * @throws Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/9/6 9:38
	 */
	public static function login(array $userInfo){
		if (count($userInfo) < 2) {
			throw new LoginException('必填项不能为空!');
		}
		/** @var UserModel $User */
		$User = UserModel::where('username', $userInfo['username'])->find();

		if (empty($User)) {
			throw new LoginException('账号不存在!');
		}

		if (!$User->isPasswordOk($userInfo['password'])) {
			self::userLoginLog($userInfo);
			throw new LoginException('密码不正确！');
		}
		self::valueSetInc($User->id,'login_count',1,'admin_user');
		/** @var \app\admin\traits\User */
		UserTrait::setCacheUser($User);
		return $User;
	}

	/**
	 * 更新用户信息
	 * @param array $userInfo
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/9/10 9:47
	 */
	public static function updateUser(array $userInfo){
		if (!Handle::valueFit($userInfo['password'], $userInfo['rePass']))
			throw new \Exception('密码不一致');

		if (empty($userInfo['name']))
			throw new \Exception('昵称不能为空!');

		unset($userInfo['rePass']);
		$User = UserModel::where('username', $userInfo['username'])->update($userInfo);

		/** @var \app\admin\Traits\User */
		UserTrait::setCacheUser($User);
	}

	/**
	 * 登录日志记录
	 * @param $userInfo array
	 * @return bool
	 * @author liuyifan
	 * @createTime 2019/9/10 11:44
	 */
	public static function userLoginLog($userInfo){
		$msg['username'] = $userInfo['username'];
		$msg['date'] = time();
		$msg['ip'] = UserTrait::getClientIp();
		$setClassName = debug_backtrace();
		array_shift($setClassName);
		$className = $setClassName[0]['function'];
		switch ($className) {
			case 'login':
				$msg['log'] = '密码错误';
				break;
			case 'setCacheUser' :
				$msg['log'] = '登录成功';
				break;
			default:
				$msg['log'] = '异常登录';
				break;
		}
		UserLog::where('username',$userInfo['username'])->insert($msg);
	}
}