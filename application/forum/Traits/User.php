<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/6/21
 * Time: 10:38
 */
namespace app\forum\Traits;
use think\facade\Session;
use think\Db;
trait User{

	/**
	 * 验证登录
	 */
	public function isUser(){
		$data = Session::get('data');
		if(empty($data)){   //未登录跳入登录页
			$this->redirect('user/login');
		}
	}

	/**
	 * 用户信息
	 */
	public static function dataInfo(){
		$data = Session::get('data');
		$data = Db::name('user')->where(array('id' => $data['id']))->find();  //我的信息
		return $data;
	}

	/**
	 * @return array
	 * 获取用户名
	 */
	public static function username(){
		$data = Session('data');
		$username = ['username' => $data['username']];
		return $username;
	}

	/**
	 * 每日刷新任务进度
	 */
	public static function taskOutInfo(){
		$data = Session('data');
		$date = [Date::getNowStartTime(),Date::getNowEndTime()];
		$map = [
			'username' => $data['username'],
			'login_type'    =>  2,
			'log'   =>  '密码正确'
		];
		$is_task = Db::name('log')->where($map)->whereTime('date','between',$date)->select();
		if (count($is_task) == 1){  //每日刷新任务进度,第一次进入登录刷新,第二次登录就不会刷新任务进度.
			Db::name('user')->where(self::username())->update(['task' => 0]);
		}
	}
}
