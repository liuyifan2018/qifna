<?php
/**
 * All my injuries are my medals
 * @author <liuyifan@915458370.email>
 * @Date: 2019/11/25 15:28
 */

namespace app\my\controller;

use app\my\service\Data;

class Index extends UCenter {


	public function index() {
		return view();
	}

	/**
	 * @param Data $data
	 * @return \think\response\View
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function getData(){
		$data = $this->data->userInfo();
		return json($data);
	}
}