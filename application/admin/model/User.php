<?php
namespace app\admin\model;

use app\admin\Model;
use think\facade\Config;

/**
 * 用户模型
 *
 * @property-read integer $id
 * @property-read string  $username
 * @property-read string  password
 */
class User extends Model{

	protected $name = 'admin_user';

	/**
	 * 验证密码是否ok
	 * @param string $pwd
	 * @return string|boolean
	 * @author liuyifanx
	 * @createTime 2019/9/6 5:25
	 */
	public function isPasswordOk(string $pwd){
		return $this->password == self::encrypt($pwd);
	}

	/**
	 * 密码加密
	 * @param $pwd
	 * @return string
	 * @author liuyifan
	 * @createTime 2019/9/6 9:28
	 */
	public static function encrypt($pwd){
		$key = Config::get('sys.uc_auth_key');
		return md5(sha1($pwd).$key);
	}
}