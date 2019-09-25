<?php

namespace app\admin\model;

use app\admin\CURD;
use app\admin\Model;
use app\admin\traits\Handle;

class Staff extends Model
{

	protected $name = 'admin_user';

	/**
	 * 必填字段
	 * @var array
	 */
	protected static $fields = ['username', 'name', 'password'];


	/**
	 * 验证新增编辑是否重复
	 * @param $param string|int 验证数据
	 * @param $field string 验证字段
	 * @return bool
	 * @throws \Exception
	 * @author liuyifan
	 * @createTime 2019/9/12 10:51
	 */
	public static function nameRepeat($param, $field) {
		if (!CURD::nameRepeat('admin_user', $param, $field, null)) return false;
		return true;
	}

	/**
	 * 新增和修改
	 * @param $data
	 * @return Staff|bool|int|string
	 * @throws \Exception
	 * @author liuyifan
	 * @createTime 2019/9/12 16:53
	 */
	public function verification($data){
		if (!Handle::dataDetection($data, self::$fields))
			throw new \Exception('必填项不能为空!');

		if (!Handle::valueFit($data['password'], $data['rePass']))
			throw new \Exception('密码不一致');

		if (!self::nameRepeat($data['name'], 'name'))
			throw new \Exception('昵称重复');

		if (!self::nameRepeat($data['username'], 'username'))
			throw new \Exception('用户名重复');

		$setClassName = debug_backtrace();
		array_shift($setClassName);
		$className = $setClassName[0]['function'];
		switch ($className){
			case 'staffAdd':
				$operation = $this->insert($data);
				break;
			case 'staffEdit':
				$operation = $this->where('id', $data['id'])->update($data);
				break;
			default:
				$operation = false;
				break;
		}
		return $operation;
	}
}