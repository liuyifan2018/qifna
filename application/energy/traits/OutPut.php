<?php

namespace app\energy\traits;

trait OutPut{

	/**
	 * 返回错误信息
	 * @param $msg
	 * @param int $code
	 * @param array $data
	 * @return \think\response\Json|void
	 * @author liuyifan
	 * @createTime 2019/9/6 2:16
	 */
	public static function outPutError($msg, $data = [], $code = 0){
		return self::results($msg, $code, $data);
	}

	/**
	 * 返回正确信息
	 * @param $msg
	 * @param int $code
	 * @param array $data
	 * @return \think\response\Json|void
	 * @author liuyifan
	 * @createTime 2019/9/6 2:16
	 */
	public static function outPutSuccess($msg, $data = [], $code = 1){
		return self::results($msg, $code, $data);
	}

	/**
	 * 返回信息
	 * @param $msg
	 * @param $code
	 * @param $data
	 * @return \think\response\Json
	 * @author liuyifan
	 * @createTime 2019/9/6 2:16
	 */
	public static function results($msg, $code, $data){
		$result['msg'] = $msg;
		$result['code'] = $code;
		$result['data'] = $data;
		$result['time'] = request()->time();
		return json($result);
	}
}