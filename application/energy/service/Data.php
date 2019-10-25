<?php
namespace app\energy\service;

use app\energy\model\ClassifyModel;

/**
 * 小程序数据服务
 * Class Data
 * @package app\energy\service
 */
class Data{


	/**
	 * 小程序首页数据
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/10/10 20:53
	 */
	public static function getData(){
		$data['classifyList'] = self::getClassify();
		return $data;
	}

	/**
	 * 分类数据
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/10/10 20:53
	 */
	public static function getClassify(){
		return ClassifyModel::classifyList();
	}

	/**
	 * 单个分类
	 * @param $id
	 * @return array|\PDOStatement|string|\think\Model|null
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/10/10 21:49
	 */
	public static function getClassifyInfo($id){
		if (empty($id)) return [];
		return ClassifyModel::classifyInfo($id);
	}
}