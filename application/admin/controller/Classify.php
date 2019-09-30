<?php

namespace app\admin\controller;

use app\admin\Controller;
use think\facade\Request;
use app\admin\service\Classify as ClassifyService;
use app\admin\model\Classify as ClassifyModel;

/**
 * 分类控制器
 * Class Classify
 * @package app\admin\controller
 */
class Classify extends Controller
{

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
				self::outPutSuccess('添加成功!');
			}
		} catch (\Exception $e) {
			return $this->outPutError($e->getMessage());
		}
		return view('classifyAdd');
	}
}