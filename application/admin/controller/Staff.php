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
	public function staffLists(){

		$lists = StaffModel::order('id asc')->paginate(8);

		return view('staffLists', [
			'lists' => $lists
		]);
	}

	/**
	 * 新增用户
	 * @return \think\response\Json|void
	 * @author liuyifan
	 * @createTime 2019/9/12 11:00
	 */
	public function staffAdd(){
		try{
			if (Request::isPost()){
				StaffService::staffAdd($this->fetch);
			}
			return view('staffAdd');
		}catch (\Exception $e){
			return $this->outPutError($e->getMessage());
		}
	}

	/**
	 * 编辑用户
	 * @return \think\response\Json|void
	 * @author liuyifan
	 * @createTime 2019/9/12 11:01
	 */
	public function staffEdit(){
		try{
			if (Request::isPost()) {
				StaffService::staffEdit($this->fetch);
			}
			return view('staffEdit');
		}catch (\Exception $e){
			return $this->outPutError($e->getMessage());
		}
	}

	public function setStatus() {
		try{
			if (Request::isGet()){
				StaffService::setStatus($this->param['id']);
			}
		}catch (\Exception $e){
			return $this->outPutError($e->getMessage());
		}
	}

	public function delete(){
		try{
			if (Request::isGet()) {
				StaffService::staffDel($this->param['id']);
			}
		}catch (\Exception $e){
			return $this->outPutError($e->getMessage());
		}
	}
}