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
}