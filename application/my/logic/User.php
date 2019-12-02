<?php
/**
 * All my injuries are my medals
 * @author <liuyifan@915458370.email>
 * @Date: 2019/12/2 15:08
 */

namespace app\my\logic;

class User{


	public static function login($user){
		if (empty($user)) throw new \Exception('网络异常,请联系管理员!');

		if (empty($user['username']) || empty($user['password'])) throw new \Exception('必填项不能为空!');

		return true;
	}
}