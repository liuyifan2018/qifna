<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/6/21
 * Time: 11:40
 */

namespace app\forum\Traits;

use app\common\OutMsg;
use think\Db;

trait CURD
{

    /**
     * 接受参数处理
     * @return array|mixed|string|\think\response\Json
     * @throws \Exception
     * @author liuyifan
     * @carete_time 2019/8/30 16:50
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
     * @param $error string 错误信息
     * @param null $id int 新增不带id，编辑判断id，自身修改不判断自身信息
     * @return mixed
     * @throws \Exception
     * @author liuyifan
     * @carete_time 2019/8/30 16:50
     */
    public static function nameRepeat($model, $value, $repeat, $error, $id = null){
        $filed = self::getModelInfo($model);
        if ($filed != null){
            if (!in_array($value, $filed)) throw new \Exception('Field does not exist!');
            $infoAll = DB::table($model)->field($value)->select();
            foreach ($infoAll as $k => $v) {
                if (!empty($id) && $infoAll[$k]['id'] == $id) { //主键为ID的表
                    unset($infoAll[$k]);
                    if ($infoAll[$k][$value] == $repeat) {  //验证编辑的
                        return OutMsg::outErrorMsg($error);
                    }
                }else{
                    if ($infoAll[$k][$value] == $repeat) {    //新增全部验证
                        return OutMsg::outErrorMsg($error);
                    }
                }
            }
            return OutMsg::outSuccessMsg('No duplicate fields');
        }
        return OutMsg::outSuccessMsg('No duplicate fields');
    }

    /**
     * 获取某表字段
     *
     * @param $modelName
     * @return array
     * @throws \Exception
     * @author liuyifan
     * @carete_time 2019/8/30 16:50
     */
    public static function getModelInfoKey($modelName)
    {
        if (empty($modelName)) throw new \Exception('Table name error!');
        $key = Db::table($modelName)->find();
        $keys = array_keys($key);
        return $keys;
    }
}