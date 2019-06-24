<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/6/21
 * Time: 10:39
 */
namespace app\forum\model;
use app\forum\Interfaces\UserFace;
use app\forum\Traits\Date;
use think\Db;
use think\Model;
use think\facade\Session;
use think\facade\Cookie;

class UserModel extends Model implements UserFace {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $data
	 * @throws \Exception
	 * 登录
	 */
	public function login( $data ){
		if(isset($data['inPass'])){
			Cookie::set('user', [
				'inPass'    =>  $data['inPass'],
				'username'  =>  $data['username'],
				'password'  =>  $data['password']
			], 86400); //记住密码
		}else{
			Cookie::set('user',null); //删除之前保留密码标记
		}
		$arr = ['username','password'];
		for ($i = 0; $i < count($arr); $i++){
			if ($data[$arr[$i]] == ""){
				throw new \Exception('{"code":"0","msg":"必填空不能为空!"}');
			}
		}
		$msg = [
			'username' => $data['username'],
			'login_type'    =>  2,
			'date'  =>  Date::getNowTime(),
			'is_show'   =>  1
		];//登录日志信息
		$userInfo = Db::table('user')->where(['username' => $data['username']])->find();
		$log = Db::table('log')->where(['username' => $data['username'],'log' => '密码错误'])
			->whereTime('date','between',[Date::getNowStartTime() , Date::getNowEndTime()])
			->count();//查询日志报错次数
		//	    if(Session::get('captcha') != $data['checkNum']){
		//		    throw new \Exception('{"code":"0" , "msg":"验证码不正确!"}');
		//	    }
		if(empty($userInfo)) throw new \Exception('{"code":"0","msg":"账号不存在!"}');
		if($userInfo['password'] != $userInfo['password']) {
			Db::table('log')->data($msg)->insert(['log' => '密码错误']);
			throw new \Exception('{"code":"0","msg":"密码错误!"}');
		}
		if($log >= 5) throw new \Exception('{"code":"0","msg":"发现异常登录,已无法登录!"}');
		Session::set('data',$userInfo);
		Db::table('log')->data($msg)->insert(['log' => '密码正确']);
		Db::table('user')->where(['username' => $data['username']])->update(['state' => '在线']);
		throw new \Exception('{"code":"1" , "msg":"登录成功!"}');
	}

	/**
	 * @param $data
	 * @throws \Exception
	 * 注册
	 */
	public function register( $data ){
		if($data['password'] != $data['password2']){
			throw new \Exception('{"code":"0" , "msg":"两次密码不一致!"}');
		}elseif(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $data['email'])){
			throw new \Exception('{"code":"0" , "msg":"邮箱格式错误!"}');
		}else{
			$insert = Db::table('user')->strict(false)->insert($data);
			if($insert){
				throw new \Exception('{"code":"1" , "msg":"注册成功!"}');
			}else{
				throw new \Exception('{"code":"0" , "msg":"注册失败!"}');
			}
		}
	}

	public function loginOut( $data ){
		Db::table('user')->where(['username' => $data['username']])->update(array('state' => '离线'));
		Session::clear('data');
		//清除缓存
		$this->redirect('login');
	}
}