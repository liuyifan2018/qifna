<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/6/25
 * Time: 21:34
 */
namespace app\forum\Traits;

trait OutMsg{

	/**
	 * @param $msg
	 * @return mixed
	 * @throws \Exception
	 * 返回报错信息
	 */
	public static function outErrorMsg($msg){
		if (empty($msg)) throw new \Exception('没有异常信息!');
		$info['code'] = 0;
		$info['msg'] = $msg;
		return $info;
	}

	/**
	 * @param $msg
	 * @return mixed
	 * @throws \Exception
	 * 返回成功信息
	 */
	public static function outSuccessMsg($msg){
		if (empty($msg)) throw new \Exception('没有异常信息!');
		$info['code'] = 1;
		$info['msg'] = $msg;
		return $info;
	}


}