<?php

namespace app\energy\controller\api;

use app\energy\service\Data;

class Classify{

	/**
	 * 指定分类数据
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/10/10 21:49
	 */
	public function classifyInfo() {
		$ClassifyInfo = Data::getClassifyInfo(input('get.id/d'));
		return $ClassifyInfo;
	}
}