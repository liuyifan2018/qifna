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
	 * 用户信息
	 */
	public static function dataInfo(){
		$data = Session::get('data');
		$data = Db::name('user')->where(array('id' => $data['id']))->find();  //我的信息
		return $data;
	}
}