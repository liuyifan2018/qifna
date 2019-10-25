<?php

namespace app\admin\traits;

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
	public static function outPutError($msg, $code = 0, $data = []){
		$data = null ? [] : $data;
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
	public static function outPutSuccess($msg, $code = 1, $data = []){
		$data = null ? [] : $data;
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