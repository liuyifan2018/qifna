<?php

namespace app\admin\service;

use app\admin\CURD;
use app\admin\model\Classify as ClassifyModel;

class Classify{

	/**
	 * 新增分类
	 * @param $data
	 * @return bool
	 * @throws \Exception
	 * @author liuyifan
	 * @createTime 2019/9/29 15:18
	 */
	public static function classifyAdd($data) {
		$dataArr = ClassifyModel::processedData() + $data;
		if (empty($dataArr['title']))
			throw new \Exception('分类名不能为空!');

		if (!CURD::nameRepeat('classify','title',$dataArr['title'],null))
			throw new \Exception('标题名重复!');

		$dataArr['sort'] = (int)$dataArr['sort'];

		$Classify = ClassifyModel::insert($dataArr, true);

		if ($Classify === false) throw new \Exception('新增失败!');
		return true;
	}
}