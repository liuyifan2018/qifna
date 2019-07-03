<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/6/21
 * Time: 11:40
 */
namespace app\forum\Traits;
use think\Db;

trait CURD{

	/**
	 * @param $modelName
	 * @return array
	 * @throws \Exception
	 * 获取字段信息
	 */
	public static function getModelInfo( $modelName ){
		if (empty($modelName)) throw new \Exception('表名错误!');
		$key = Db::name($modelName)->find();
		$keys = array_keys($key);
		return $keys;
	}

	/**
	 * @return array|mixed|string|\think\response\Json
	 * @throws \Exception
	 */
	public static function PurificationParam(){
		$data = json_decode(file_get_contents('php://input'),true);
		if (empty($data)) return null;
		if (is_array($data)){
			foreach ($data as $k => $v){
				$data[$k] = trim($v);
			}
		}else{
			$data = trim($data);
		}
		return $data;
	}
}