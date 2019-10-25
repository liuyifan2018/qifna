<?php

namespace app\admin\controller;

use app\admin\Controller;
use app\admin\service\Set as SetService;
use think\facade\Request;

class Set extends Controller{

	public function index() {
		if ($this->isStop == 1) {
			return view('empty/stop');
		}
		return view('index');
	}

	/**
	 * 封闭/解封 站点
	 * @param SetService $set
	 * @author liuyifan
	 * @createTime 2019/10/24 17:17
	 */
	public function stop(SetService $set) {
		try {
			if(Request::isGet()){
				$set->stop();
			}
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
	}
}