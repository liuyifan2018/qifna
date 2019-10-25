<?php
namespace app\admin;

use think\Model as BaseModel;

class Model extends BaseModel{

	public function getSingleInfo($id,$model){
		if (empty($id)) throw new \Exception('参数错误');
		db($model)->where()->find();
	}
}