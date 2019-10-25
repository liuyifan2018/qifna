<?php

namespace app\admin\service;

use app\admin\model\Classify as ClassifyModel;
use app\admin\traits\Handle;
use app\admin\Service;

class Classify extends Service{


	/*********************** 必须实现的方法 ***************************/

	/**
	 * @param $id
	 * @param $model
	 * @return mixed|void
	 */
	public function getSingleInfo($id, $model) {

	}

	public function lInsert($data) {
		// TODO: Implement lInsert() method.
	}

	public function lUpdate($data) {
		// TODO: Implement lUpdate() method.
	}

	public function lDelete($id) {
		// TODO: Implement lDelete() method.
	}

	/**
	 * 获取单个分类信息
	 * @param $id
	 * @return array|\PDOStatement|string|\think\Model|null
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/10/8 9:41
	 */
	public function ClassifyInfo($id) {
		$classifyInfo = $this->model->getSingleInfo($id,'classify');
		$classifyInfo = ClassifyModel::where('id', '=', $id)->find();
		return !empty($classifyInfo) ? $classifyInfo : null;
	}

	/**
	 * 新增分类
	 * @param $data
	 * @return bool
	 * @throws \Exception
	 * @author liuyifan
	 * @createTime 2019/9/29 15:18
	 */
	public static function classifyAdd($data) {
		$Classify = new ClassifyModel();
		if ($Classify->verification(ClassifyModel::processedData() + $data) === false)
			throw new \Exception('新增失败!');
		return true;
	}

	/**
	 * 编辑分类
	 * @param $data
	 * @return bool
	 * @throws \Exception
	 * @author liuyifan
	 * @createTime 2019/9/29 15:18
	 */
	public static function classifyEdit($data) {
		$Classify = new ClassifyModel();
		if ($Classify->verification($data) === false)
			throw new \Exception('编辑失败!');
		return true;
	}

	/**
	 * 修改状态
	 * @param $id
	 * @return bool
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/10/8 9:47
	 */
	public function setStatus($id) {
		if (!Handle::hasParam($id))
			throw new \Exception('参数错误!');
		$classifyInfo = $this->ClassifyInfo($id);
		switch ($classifyInfo['status']) {
			case 1:
				if (ClassifyModel::where('id', '=', $id)->update(['status' => 2]))
					return true;
				break;
			case 2:
				if (ClassifyModel::where('id', '=', $id)->update(['status' => 1]))
					return true;
				break;
			default:
				return false;
		}
		return false;
	}

	/**
	 * 删除分类
	 * @param $id
	 * @return bool
	 * @throws \Exception
	 * @author liuyifan
	 * @createTime 2019/10/11 10:42
	 */
	public static function classifyDel($id){
		if (!Handle::hasParam($id))
			throw new \Exception('参数错误!');
		$del = ClassifyModel::classifyDel($id);
		if ($del === true) return true;
		return false;
	}
}