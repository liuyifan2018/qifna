<?php
namespace app\energy\controller\api;

use app\energy\service\Data as DataService;

class Data extends Base{

	/**
	 * 小程序首页数据
	 * @return int
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/10/10 20:54
	 */
	public function getData(){
		$data = DataService::getData();
		return json($data);
	}

}