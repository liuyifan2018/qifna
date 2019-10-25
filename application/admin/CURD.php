<?php

namespace app\admin;

use think\Db;
use think\facade\Request;

/**
 * Trait CURD
 *
 * @property-read \app\Request $request
 * @property-read array $meta
 * @property-read array $statusCondition
 * @mixin \app\admin\AdminController
 * @package app\admin
 */
trait CURD
{

	/**
	 * 获取调用者函数方法名
	 * @return mixed
	 * @author liuyifan
	 * @createTime 2019/9/10 11:06
	 */
	protected static function getClass() {
		$setClassName = debug_backtrace();
		array_shift($setClassName);
		return $setClassName[0]['function'];
	}

	/**
	 * 更新字段值
	 * @param $id string|integer 条件
	 * @param $key string 键
	 * @param $val integer 值
	 * @param $model string 模型
	 * @return bool
	 * @author liuyifan
	 * @createTime
	 */
	protected static function valueSetInc($id, $key, $val, $model) {
		return Db::name($model)->where('id','=',$id)->setInc($key, $val) === true ? true : false;

	}

	/**
	 * 检查新增或编辑重复
	 *
	 * @param $model string 数据库表名
	 * @param $value string 判断字段
	 * @param $repeat string 新增数据字段
	 * @param null $id int 新增不带id，编辑判断id，自身修改不判断自身信息
	 * @return mixed
	 * @throws \Exception
	 * @author liuyifan
	 * @createTime 2019/9/12 10:36
	 */
	public static function nameRepeat($model, $value, $repeat, $id = null){
		$filed = self::getModelInfo($model);
		if ($filed != null){
			if (!in_array($value, $filed)) throw new \Exception('Field does not exist!');
			$infoAll = Db::name($model)::field($value)->select();
			foreach ($infoAll as $k => $v) {
				if (!empty($id) && $infoAll[$k]['id'] == $id) {	//编辑
					unset($infoAll[$k]);
					if ($infoAll[$k][$value] == $repeat) return false;
				}else{	//新增
					if ($infoAll[$k][$value] == $repeat) return false;
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * 获取某表字段
	 * @param $modelName
	 * @return array
	 * @throws \Exception
	 * @author liuyifan
	 * @createTime 2019/9/12 10:38
	 */
	public static function getModelInfo($modelName){
		if (empty($modelName)) throw new \Exception('Table name error!');
		$key = Db::name($modelName)::find();
		$keys = array_keys($key);
		return $keys;
	}

}