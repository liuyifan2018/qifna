<?php

namespace app\admin\model;

use app\admin\Model;

class Classify extends Model{

	protected $name = 'classify';

	/**
	 * 增加需字段
	 * @return array|mixed
	 * @author liuyifan
	 * @createTime 2019/9/29 15:17
	 */
	public static function processedData() {
		return $data = [
			'create_time' => time(),
			'is_del'      => 1,
			'status'      => 1,
			'c_id'        => 0,
			'classify'    => 1
		];
	}
}