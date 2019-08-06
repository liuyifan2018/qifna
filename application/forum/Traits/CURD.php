<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/6/21
 * Time: 11:40
 */

namespace app\forum\Traits;

use app\forum\Traits\OutMsg;
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
     * @param $model string 数据库表名
     * @param $value string 判断字段
     * @param $repeat string 新增数据字段
     * @param $error string 错误信息
     * @param null $id int 新增不带id，编辑判断id，自身修改不判断自身信息
     * @return mixed
     * @throws \Exception
     * 检查新增重复
     */
    public static function nameRepeat($model, $value, $repeat, $error, $id = null)
    {
        $valueIn = $value;
        $filed = self::getModelInfoKey($model);
        if ($filed != null) {
            if (!in_array($value, $filed)) throw new \Exception('Field does not exist!');
            if ($model == 'hk_home_admin') {
                $value = "$value,uid";
            } else {
                $value = "$value,id";
            }
            $infoAll = Db::name($model)->field($value)->select();
            foreach ($infoAll as $k => $v) {
                if (empty($infoAll[$k]['id'])) {
                    if (!empty($id) && $infoAll[$k]['uid'] == $id) {
                        unset($infoAll[$k]);
                        if ($infoAll[$k][$valueIn] == $repeat) {
                            return OutMsg::outErrorMsg($error);
                        }
                    }
                }
                if (!empty($id) && $infoAll[$k]['id'] == $id) {
                    unset($infoAll[$k]);
                    if ($infoAll[$k][$valueIn] == $repeat) {
                        return OutMsg::outErrorMsg($error);
                    }
                }
            }
            return OutMsg::outSuccessMsg('No duplicate fields');
        }
        return OutMsg::outSuccessMsg('No duplicate fields');
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