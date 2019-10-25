<?php
/**
 * @author liuyifan
 * @createTime 2019-8-10 11:20
 * I know no such things as genius,it is nothing but labor and diligence.
 * 能量工厂小程序登录接口
 */

namespace app\energy\controller\api;

use app\energy\common\WxLogin;
use app\energy\model\UserModel;
use app\energy\common\OutMsg;
use app\energy\traits\OutPut;
use think\facade\Request;
use app\energy\service\Login;

class User extends Base{
    /**
     * @var $model
     * 公共模型
     */
    protected $model;

    /**
     * @var $param
     * 获取参数
     */
    protected $param;

    /**
     * User constructor.
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();
        try {
            $this->model = new UserModel();
        } catch (\Exception $e) {
            return OutMsg::outAbnormalMsg($e->getMessage());
        }
    }

    public function model()
    {
        return new UserModel();
    }


    public function getOpenId()
    {
        $code = $_GET['code'];
        $getOpenIdUrl = WxLogin::getOpenId($code);
        //获取GET请求
		function httpGet($getOpenIdUrl){
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);//这里少了个T【CURLOP_TIMEOUT , CURLOPT_TIMEOUT】
			curl_setopt($curl, CURLOPT_URL, $getOpenIdUrl);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
			curl_setopt($curl, CURLOPT_HEADER, FALSE);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
			$res = curl_exec($curl);
			curl_close($curl);
			//取出openid
			$data = json_decode($res,true);
			$openid = $data['openid'];
			return $openid;
		}
        //发送
        $str = httpGet($getOpenIdUrl);
        echo $str;
    }


    /**
     * @return \think\response\Json
     * @throws \Exception
     */
    public function wxLogin()
    {
        try {
            if (Request::isPost()) {
                $data = input('post.');
				$wxLogin = Login::wxLogin($data);
                return OutPut::outPutSuccess('授权成功！',$wxLogin);
            }
        } catch (\Exception $e) {
            return OutPut::outPutError($e->getMessage());
        }
    }

}
