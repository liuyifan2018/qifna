<?php
namespace app\admin\common;

/**
 * 参数获取
 * Trait Param
 * @package app\admin\common
 */
trait Param{

	/**
	 * 处理Fetch接收的参数
	 * @return array|mixed|string|null
	 * @author liuyifan
	 * @createTime 2019/9/6 1:13
	 */
	public static function PurificationPostFetchParam(){
		$data = json_decode(file_get_contents('php://input'), true);
		if (empty($data)) return null;
		if (is_array($data)) {
			foreach ($data as $k => $v) {
				$data[$k] = trim($v);
			}
		} else {
			$data = trim($data);
		}
		return $data;
	}

	/**
	 * 处理Fetch的Get请求
	 * @return array|mixed|string|null
	 */
	public static function PurificationGetFetchParam(){
		$data = input('param.');
		if (empty($data)) return null;
		if (is_array($data)) {
			foreach ($data as $k => $v) {
				$data[$k] = trim($v);
			}
		} else {
			$data = trim($data);
		}
		return $data;
	}
}