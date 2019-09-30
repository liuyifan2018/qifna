<?php
namespace app\energy\common;

final class WxLogin{

    /**
     * @param $code
     * @return string
     * 获取openId的配置信息
     */
    public static function getOpenId($code){
        $appid = "wxa24d6c0c3c06d3e2";
        $secret = "304a23926bea4b24a5c4ae5dc113f7f7";
        $api = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";
        return $api;
    }
}