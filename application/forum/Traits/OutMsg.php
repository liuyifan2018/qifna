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
	 * @var $code
	 * 状态码
	 */
	protected $code;

	/**
	 * @var $msg
	 * 返回信息
	 */
	protected $msg;

	protected function __construct()
	{
		//定义初始值
		$this->code = 0;
		$this->msg = "";
	}

	/**
	 * @param $code
	 * @param $msg
	 * @return mixed
	 * @throws \Exception
	 * 返回报错信息
	 */
	public static function outMsg($code = null,$msg = null){
		if (empty($msg)) throw new \Exception('没有信息!');
		$info['code'] = $code;
		$info['msg'] = $msg;
		return json($info);
	}

	/**
	 * @param $msg
	 * @return mixed
	 * @throws \Exception
	 * 返回报错信息
	 */
	public static function outErrorMsg($msg){
		$info = self::outMsg(0,$msg);
		return $info;
	}

	/**
	 * @param $msg
	 * @return mixed
	 * @throws \Exception
	 * 返回成功信息
	 */
	public static function outSuccessMsg($msg){
		$info = self::outMsg(1,$msg);
		return $info;
	}

	/**
	 * @param $msg
	 * @return \think\response\Json
	 * @throws \Exception
	 * 返回异常信息
	 */
	public static function outAbnormalMsg($msg){
		$info = self::outMsg(0,$msg);
		return $info;
	}


}