<?php

namespace app\admin\controller;

use app\admin\Controller;
use app\admin\ultimate\Super;
use think\facade\Request;
use app\admin\service\Classify as ClassifyService;
use app\admin\model\Classify as ClassifyModel;

/**
 * 分类控制器
 * Class Classify
 * @package app\admin\controller
 */
class Classify extends Controller {



	public function initialize() {
		 new Base(Super::getFileName());
	}

	/**
	 * 分类列表
	 * @return \think\response\View
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/9/29 10:29
	 */
	public function classify() {
		$lists = ClassifyModel::where('is_del', '=', 1)->order('sort asc')->paginate(8);
		return view('classify', [
			'lists' => $lists
		]);
	}

	/**
	 * 添加分类
	 * @return \think\response\Json|\think\response\View|void
	 * @author liuyifan
	 * @createTime 2019/9/29 9:55
	 */
	public function classifyAdd() {
		try {
			if (Request::isPost()) {
				ClassifyService::classifyAdd($this->fetch);
				return self::outPutSuccess('添加成功!');
			}
		} catch (\Exception $e) {
			return self::outPutError($e->getMessage());
		}
		return view('classifyAdd');
	}

	/**
	 * 编辑分类
	 * @return \think\response\Json|\think\response\View|void
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/9/29 10:27
	 */
	public function classifyEdit() {
		try {
			if (Request::isPost()) {
				ClassifyService::classifyEdit($this->fetch);
				return self::outPutSuccess('编辑成功!');
			}
		} catch (\Exception $e) {
			return self::outPutError($e->getMessage());
		}
		$classifyInfo = ClassifyService::ClassifyInfo($this->param['id']);
		return view('classifyEdit',[
			'classifyInfo'	=>	$classifyInfo
		]);
	}

	/**
	 * 修改状态
	 * @return \think\response\Json|void
	 * @author liuyifan
	 * @createTime 2019/10/8 9:36
	 */
	public function setStatus($id = '') {
		try {
			if (Request::isGet()) {
				$ClassifyService = new ClassifyService();
				$ClassifyService->setStatus($this->param['id']);
				return self::outPutSuccess('修改成功!');
			}
		} catch (\Exception $e) {
			return self::outPutError($e->getMessage());
		}
	}

	/**
	 * 删除
	 * @return \think\response\Json|void
	 * @author liuyifan
	 * @createTime 2019/10/11 10:43
	 */
	public function classifyDel() {
		try {
			if (Request::isGet()) {
				ClassifyService::classifyDel($this->param['id']);
				return self::outPutSuccess('删除成功!');
			}
		} catch (\Exception $e) {
			return self::outPutError($e->getMessage());
		}
	}
}