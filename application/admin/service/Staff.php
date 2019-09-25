<?php

namespace app\admin\service;

use app\admin\Controller;
use app\admin\traits\Handle;
use app\admin\model\Staff as StaffModel;

class Staff extends Controller
{
	/**
	 * 获取单个用户信息
	 * @param $id
	 * @return array|\PDOStatement|string|\think\Model|null
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/9/12 10:20
	 */
	public static function staffInfo($id) {
		return StaffModel::where('id', $id)->find();
	}

	/**
	 * 新增用户
	 * @param $data
	 * @return bool
	 * @throws \Exception
	 * @author liuyifan
	 * @createTime 2019/9/12 10:53
	 */
	public static function staffAdd($data) {
		StaffModel::verification($data);
		return true;
	}

	/**
	 * 编辑用户
	 * @param $data
	 * @return bool
	 * @throws \Exception
	 * @author liuyifan
	 * @createTime 2019/9/12 16:54
	 */
	public static function staffEdit($data) {
		StaffModel::verification($data);
		return true;
	}

	/**
	 * 修改数据状态
	 * @param $id int 数据唯一标识
	 * @return bool
	 * @throws \Exception
	 * @author liuyifan
	 * @createTime 2019/9/12 10:14
	 */
	public static function setStatus($id) {
		if (!Handle::hasParam($id))
			throw new \Exception('参数错误');

		$staffInfo = self::staffInfo($id);
		if (empty($staffInfo))
			throw new \Exception('用户不存在!');

		$status = Handle::resetStatus($staffInfo['status']);
		$set = $staffInfo->where('id', $id)->update(['status' => $status]);

		if ($set === false) throw new \Exception('更改失败!');
		return true;
	}

	/**
	 * @param $id
	 * @return bool
	 * @throws \Exception
	 * @author liuyifan
	 * @createTime 2019/9/12 16:55
	 */
	public static function staffDel($id){
		if (!Handle::hasParam($id))
			throw new \Exception('参数错误');

		StaffModel::where('id',$id)->delete();
		return true;
	}
}