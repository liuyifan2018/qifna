<?php

namespace app\admin\traits;

trait Handle{

	/**
	 * 如果参数为空不验证参数
	 *
	 * @param $param int
	 * @return mixed
	 * @author liuyifan
	 * @createTime 2019/9/4 22:57
	 */
	public static function hasParam($param){
		if (!empty((int)$param)) return true;
		return false;
	}

	/**
	 * @param $data array 验证的数据
	 * @param $fields array 验证的字段
	 * @return bool
	 * @author liuyifan
	 * @createTime 2019/9/6 10:03
	 */
	public static function dataDetection($data, $fields){
		for ($i = 0; $i < count($fields); $i++) {
			if ($data[$fields[$i]] == "") return false;
		}
		return true;
	}

	/**
	 * 修改数据状态
	 * @param $status string 更改状态
	 * @return int
	 */
	public static function resetStatus($status){
		switch ($status){
			case 1:
				$status = 2;
				break;
			case 2:
				$status = 1;
				break;
			default:
				$status = 1;
				break;
		}
		return $status;
	}

	/**
	 * 检测两个值是否一致
	 * @param $value string
	 * @param $reValue string
	 * @return bool
	 * @author liuyifan
	 * @createTime 2019/9/9 20:42
	 */
	public static function valueFit($value, $reValue){
		return $value == $reValue ? true : false;
	}
}