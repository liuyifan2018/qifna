<?php
/**
 * All my injuries are my medals
 * @author <liuyifan@915458370.email>
 * @Date: 2019/11/30 15:11
 */

namespace app\my\model;

use think\Db;
use think\Model;

class User extends Model{

	public $name = 'user';

	/**
	 * 验证密码
	 *
	 * @param $pwd
	 * @return string
	 */
	public static function isPassword($pwd) {
		return md5(md5($pwd) . 'qifan');
	}

	/**
	 * 记录登录日志
	 *
	 * @param $user
	 * @param $ip
	 */
	public function loginLog($user, $ip) {
		$data = [
			'username' => $user['username'],
			'date'     => time(),
			'msg'      => '登录成功!',
			'ip'       => $ip
		];
		db('userLog')->insert($data);
	}
}