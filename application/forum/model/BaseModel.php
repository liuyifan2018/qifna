<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/7/1
 * Time: 16:26
 */
namespace app\forum\model;
use app\forum\Traits\OutMsg;
use think\Model;

class BaseModel extends Model {

	/**
	 * @param $data
	 * @param $arr
	 * @return mixed
	 * @throws \Exception
	 * 检测必须项是否为空
	 */
	protected function Handle($data,$arr){
		for ($i = 0; $i < count($arr); $i++){
			if($data[$arr[$i]] == ""){
				return OutMsg::outErrorMsg("必填项不能为空!");
			}
		}
		exit;
	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws \Exception
	 * 检测参数
	 */
	protected function is_empty($id){
		if (empty($id) || !is_numeric($id)) return OutMsg::outErrorMsg('参数错误!');
		exit;
	}
}