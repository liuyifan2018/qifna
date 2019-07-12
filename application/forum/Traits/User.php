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
			header('Location: http://localhost/Postbar/Public/Index/User/login');
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
}