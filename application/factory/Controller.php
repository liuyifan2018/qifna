<?php

namespace app\factory;

use think\Controller as BaseController;

/**
 * Class Controller
 * @package app\factory
 */
class Controller extends BaseController{

	public $stop = 0;

	/**
	 * Controller constructor.
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function __construct(){
		$this->stopSealing();
	}

	/**
	 * @return int
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function stopSealing(){
		$config = Model::where('id','=',1)->find();
		if ($config['stop'] == 1){
			$this->stop = 1;
		}
		return $this->stop;
	}
}