<?php

namespace app\admin\controller;

use app\admin\Controller;
use app\admin\model\Staff as StaffModel;
use app\admin\service\Staff as StaffService;
use think\facade\Request;

class Staff extends Controller{

	/**
	 * 获取管理用户列表
	 *
	 * @return \think\response\View
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/9/10 10:22
	 */
	public function staffLists() {

		$lists = StaffModel::order('id asc')->paginate(8);
		return view('staffLists', [
			'lists'  => $lists,
		]);
	}

	/**
	 * 搜索查询单个用户
	 *
	 * @return mixed
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifna
	 * @createTime 2019/9/27 14:50
	 */
	public function staffSearchInfo(){
		if (Request::isPost()) {
			$userInfo['isUser'] = 1;
			$userInfo['data'] = StaffService::staffSearch($this->fetch['username']);
			if (empty($userInfo['data'])){
				$userInfo['isUser'] = 3;
			}
			return json($userInfo);
		}
	}

	/**
	 * 新增用户
	 * @return \think\response\Json|void
	 * @author liuyifan
	 * @createTime 2019/9/12 11:00
	 */
	public function staffAdd() {
		try {
			if (Request::isPost()) {
				StaffService::staffAdd($this->fetch);
				return self::outPutSuccess('新增成功');
			}
			return view('staffAdd');
		} catch (\Exception $e) {
			return self::outPutError($e->getMessage());
		}
	}

	/**
	 * 编辑用户
	 * @return \think\response\Json|void
	 * @author liuyifan
	 * @createTime 2019/9/12 11:01
	 */
	public function staffEdit() {
		try {
			if (Request::isPost()) {
				StaffService::staffEdit($this->fetch);
				return self::outPutSuccess('编辑成功');
			}
			return view('staffEdit',[
				'staffInfo'	=>	StaffService::staffInfo($this->param['id'])
			]);
		} catch (\Exception $e) {
			self::outPutError($e->getMessage());
		}
	}

	/**
	 * 修改状态
	 * @return \think\response\Json|void
	 * @author liuyifan
	 * @createTime 2019/9/12 11:02
	 */
	public function setStatus() {
		try {
			if (Request::isGet()) {
				StaffService::setStatus($this->param['id']);
				return self::outPutSuccess('修改成功');
			}
		} catch (\Exception $e) {
			self::outPutError($e->getMessage());
		}
	}

	/**
	 * 删除用户
	 * @return \think\response\Json|void
	 * @author liuyifan
	 * @createTime 2019/9/12 11:03
	 */
	public function staffDel() {
		try {
			if (Request::isGet()) {
				StaffService::staffDel($this->param['id']);
				return self::outPutSuccess('删除成功');
			}
		} catch (\Exception $e) {
			return self::outPutError($e->getMessage());
		}
	}
}