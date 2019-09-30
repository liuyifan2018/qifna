<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/6/21
 * Time: 11:40
 */

namespace app\energy\common;

use think\Db;

trait CURD
{

	/**
	 * @param $modelName
	 * @return array
	 * @throws \Exception
	 * 获取字段信息
	 */
	public static function getModelInfo($modelName)
	{
		if (empty($modelName)) throw new \Exception('表名错误!');
		$key = Db::name($modelName)->find();
		$keys = array_keys($key);
		return $keys;
	}

	/**
	 * 接收参数
	 *
	 * @return array|mixed|string|\think\response\Json
	 * @throws \Exception
	 */
	public static function PurificationParam()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (empty($data)) return null;
		if (is_array($data)) {
			foreach ($data as $k => $v) {
				$data[$k] = trim($v);
			}
		} else {
			$data = trim($data);
		}
		return $data;
	}

	/**
	 * 检查新增重复
	 *
	 * @param $model string 数据库表名
	 * @param $value string 判断字段
	 * @param $repeat string 新增数据字段
	 * @param null $id int 新增不带id，编辑判断id，自身修改不判断自身信息
	 * @return boolean
	 * @throws \Exception
	 * @author liuyifan
	 * @create_time 2019/9/1 10:00
	 */
	public static function nameRepeat($model, $value, $repeat, $id = null){
		$filed = self::getModelInfoKey($model); //获取表的全部字段KEY
		if ($filed != null) {
			if (!in_array($value, $filed)) throw new \Exception('Field does not exist!');
			$infoAll = Db::name($model)->field($value)->select();
			foreach ($infoAll as $k => $v) {
				if (empty($infoAll[$k]['id'])) {    //主键为UID的表
					if ($infoAll[$k]['uid'] == $id) {    //判断编辑
						unset($infoAll[$k]); //编辑不判断自身重复
						if ($infoAll[$k][$value] == $repeat) return false;
					} else {
						if ($infoAll[$k][$value] == $repeat) return false;    //判断新增
					}
				}
				if (!empty($id) && $infoAll[$k]['id'] == $id) { //主键为ID的表
					unset($infoAll[$k]);
					if ($infoAll[$k][$value] == $repeat) return false;
				} else {
					if ($infoAll[$k][$value] == $repeat) return false; //新增全部验证
				}
			}
			return true;
		}
		throw new \Exception('Table field does not exist');
	}

	/**
	 * @param $modelName
	 * @return array
	 * @throws \Exception
	 * 获取某表字段
	 */
	public static function getModelInfoKey($modelName)
	{
		if (empty($modelName)) throw new \Exception('Table name error!');
		$key = Db::name($modelName)->find();
		$keys = array_keys($key);
		return $keys;
	}

}