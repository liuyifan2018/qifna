<?php
namespace app\admin;

use app\admin\common\Param;
use app\admin\model\Set;
use app\admin\traits\OutPut;
use app\admin\traits\User;
use app\admin\ultimate\Super;
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
	 * 获取服务类
	 * @var $service
	 */
	protected $service;

	/**
	 * 文件名字
	 * @var @dirName
	 */
	protected $fileName;

	/**
	 * 停封站点
	 * @var int
	 */
	public $isStop = 0;

	/**
	 * 后台初始化
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/9/7 18:08
	 */
	public function initialize(){
		$this->isStop();
		$this->fetch = Param::PurificationPostFetchParam();
		$this->param = Param::PurificationGetFetchParam();
		try{
			if (!User::isLogin()) throw new \Exception('登录超时!');
			$this->user = User::userInfo();
		}catch (\Exception $e){
			$this->error($e->getMessage(),url('User/login'));
		}
	}

	/**
	 * 站点状态
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function isStop(){
		$isStop = Set::where('id','=',1)->find();
		if ($isStop['stop'] == 1){
			$this->isStop = 1;
		}
	}
}