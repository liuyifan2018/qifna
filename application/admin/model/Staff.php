<?php

namespace app\admin\model;

use app\admin\CURD;
use app\admin\Model;
use app\admin\traits\Handle;
use app\admin\service\Staff as StaffService;

class Staff extends Model
{

	protected $name = 'admin_user';

	/**
	 * 必填字段
	 * @var array
	 */
	protected static $fields = ['username', 'name', 'password'];

	/**
	 * 新增和修改
	 * @param $data
	 * @return Staff|bool|int|string
	 * @throws \Exception
	 * @author liuyifan
	 * @createTime 2019/9/12 16:53
	 */
	public function verification($data) {
		$setClassName = debug_backtrace();
		array_shift($setClassName);
		$className = $setClassName[0]['function'];

		//密码加密
		$data['rePass'] = User::encrypt($data['rePass']);

		if ($className == 'staffEdit' && !Handle::hasParam($data['id']))
			throw new \Exception('参数错误!');

		if (!Handle::dataDetection($data, self::$fields))
			throw new \Exception('必填项不能为空!');

		if (!Handle::valueFit($data['password'], $data['rePass']))
			throw new \Exception('密码不一致');

		if (!CURD::nameRepeat('admin_user', 'name', $data['name'], $className == 'staffAdd' ? null : $data['id']))
			throw new \Exception('昵称重复');

		if (!CURD::nameRepeat('admin_user', 'username', $data['username'], $className == 'staffAdd' ? null : $data['id']))
			throw new \Exception('用户名重复');

		if ($className == 'staffAdd') {    //新增操作
			$data['password'] = User::encrypt($data['password']);
			$data['create_time'] = time();
		}

		if ($className == 'staffEdit' && StaffService::staffInfo($data['id'])['password'] != $data['password']) {    //编辑操作
			$data['password'] = User::encrypt($data['password']);
		}

		unset($data['rePass']);
		switch ($className) {
			case 'staffAdd':
				$operation = $this->insert($data);
				break;
			case 'staffEdit':
				$operation = $this->where('id','=', $data['id'])->update($data);
				break;
			default:
				$operation = false;
				break;
		}
		return $operation;
	}
}