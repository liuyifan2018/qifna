<?php

namespace app\admin\traits;

use app\admin\model\User as UserModel;
use think\facade\Cache;
use think\facade\Cookie;
use app\admin\service\User as UserService;

trait User{

	/**
	 * 查询用户信息是否存在
	 * @return int|mixed
	 * @author liuyifan
	 * @createTime 2019/9/5 17:59
	 */
	public static function getCacheUser(){
		return Cookie::has('uid') == true ? Cookie::get('uid') : 0;
	}

	/**
	 * 检测是否登录
	 * @return bool
	 * @author liuyifan
	 * @createTime 2019/9/6 9:27
	 */
	public static function isLogin(){
		return self::getCacheUser() == 0 ? false : true;
	}

	/**
	 * 缓存用户模型
	 * @param UserModel $User
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/9/6 9:30
	 */
	public static function setCacheUser($User){
		$userAuthSign = sha1(md5($User->id . "." . $User->username) . request()->time());
		Cookie::set('user_auth_sign', $userAuthSign);
		Cookie::set('uid', $User['id']);
		self::cacheUser(Cookie::get('uid'));	//更新缓存信息
		UserService::userLoginLog(self::userInfo());
	}

	/**
	 * 更新缓存信息
	 * @param $id
	 * @return array|\PDOStatement|string|\think\Model|null
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/9/5 20:48
	 */
	public static function cacheUser($id){
		$id = Handle::hasParam($id) ? $id : self::getCacheUser();
		$userInfo = UserModel::where(['id' => $id])->cache('userInfo', 86400)->find();
		return empty($userInfo) ? [] : $userInfo;
	}

	/**
	 * 获取用户信息
	 * @return array|mixed|\PDOStatement|string|\think\Model|null
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/9/10 9:38
	 */
	public static function userInfo(){
		return empty(Cache::get('userInfo')) ? self::cacheUser(Cookie::get('uid')) : Cache::get('userInfo');
	}

	/**
	 * 获取客户端IP地址
	 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
	 * @return mixed
	 * @author liuyifan
	 * @createTime 2019/9/10 11:35
	 */
	public static function getClientIp($type = 0){
		$type       =  $type ? 1 : 0;
		static $ip  =   NULL;
		if ($ip !== NULL) return $ip[$type];
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$pos    =   array_search('unknown',$arr);
			if(false !== $pos) unset($arr[$pos]);
			$ip     =   trim($arr[0]);
		}elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip     =   $_SERVER['HTTP_CLIENT_IP'];
		}elseif (isset($_SERVER['REMOTE_ADDR'])) {
			$ip     =   $_SERVER['REMOTE_ADDR'];
		}
		// IP地址合法验证
		$long = sprintf("%u",ip2long($ip));
		$ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
		return $ip[$type];
	}

}