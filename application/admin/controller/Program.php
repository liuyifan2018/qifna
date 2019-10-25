<?php

namespace app\admin\controller;

use app\admin\Controller;
use app\admin\model\Program as ProgramModel;

/**
 * 功能控制器
 * Class Program
 * @package app\admin\controller
 */
class Program extends Controller{

	/**
	 * 用户功能列表
	 * @return \think\response\View
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/10/11 10:08
	 */
	public function program() {
		return view('program', [
			'lists' => ProgramModel::where(ProgramModel::whereProgram())
				->order(['sort' => 'desc', 'id' => 'desc'])
				->paginate(8)
		]);
	}

	public function programAdd(){
		return view('programAdd');
	}

	public function programEdit(){
		return view('programEdit');
	}
}