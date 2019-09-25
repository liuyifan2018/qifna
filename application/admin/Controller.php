<?php
namespace app\admin;

use app\admin\common\Param;
use app\admin\traits\OutPut;
use app\admin\traits\User;
use think\Controller as BaseController;

/**
 * Class Controller
 * @package app\admin
 */
class Controller extends BaseController{
	use OutPut;

	/**
	 * 接收参数
	 * @var $param
	 */
	protected $param;

	/**
	 * 用户信息
	 * @var $user
	 */
	protected $user;

	/**
	 * 处理fetch请求
	 * @var $fetch
	 */
	protected $fetch;

	/**
	 * 后台初始化
	 * @author liuyifan
	 * @createTime 2019/9/7 18:08
	 */
	public function initialize(){
		parent::initialize(); // TODO: Change the autogenerated stub
		$this->fetch = Param::PurificationPostFetchParam();
		$this->param = Param::PurificationGetFetchParam();
		try{
			if (!User::isLogin()) throw new \Exception('登录超时!');
			$this->user = User::userInfo();
		}catch (\Exception $e){
			$this->error($e->getMessage(),url('User/login'));
		}
	}
}