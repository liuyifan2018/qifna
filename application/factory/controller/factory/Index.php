<?php
namespace app\factory\controller\factory;

use app\factory\controller\Controller;
use think\facade\Request;

/**
 * 主生产类
 * Class Index
 * @package app\factory\controller
 */
class Index extends Controller {


	public function factory(){
		if (Request::isGet()){
			$status = $this->hero->heroPool(input('get.'));
			if ($status === false){
				echo '生产失败!';
			}
			echo '生产成功!';
		}
	}
}