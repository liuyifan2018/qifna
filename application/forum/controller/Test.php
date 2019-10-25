<?php

namespace app\forum\controller;

/**
 *
 * Class Test
 * @package app\forum\controller
 */
class Test
{

	public $b = 'b';

	/**
	 * widget导入数据
	 */
	public function index($password = '') {
		if ($password == 'liuyifan') {
			$appId = "wx3e596d4830500318";
			$appSecret = "f0d708ff4813c8264fedb422a81ce1d0";
			$getTokenApi = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appId&secret=$appSecret";
			$tempArr = json_decode($this->curl_get_contents($getTokenApi), true);
			$access_token = $tempArr['access_token'];
			$api = "https://api.weixin.qq.com/wxa/setdynamicdata?access_token=" . $access_token;
			$keywords = json_decode($this->curl_get_contents('http://wy.51daoteng.com/phpexcel/import.php'));
			foreach ($keywords as $k => $v) {
				$over = $this->curl_post_contents($api, json_encode([
					"data"     => json_encode([
						"items"     => [[
											"keyword" => $v[0]
										]],
						"attribute" => [
							"count"      => count($keywords),
							"totalcount" => count($keywords),
							"id"         => $k,
							"seq"        => 0
						]
					]),
					"lifespan" => 86400,
					"query"    => json_encode([
						"type" => 1000078
					]),
					"scene"    => 1
				], JSON_UNESCAPED_UNICODE));
				var_dump($over);
			}
		} else {
			echo '密码错误!';
		}

	}

	function curl_post_contents($url, $data = null) {
		$curl = curl_init();
		//设置超时
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		//设置header
		curl_setopt($curl, CURLOPT_HEADER, false);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		if (!empty($data)) {
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
	}

	public function getlatInfo() {
		header("content-type:text/html;charset=utf-8");
		$get_ip = $_SERVER['REMOTE_ADDR'];
		$content = file_get_contents("http://api.map.baidu.com/location/ip?ak=Gi1nULBk8PY6PdBVyqnrT8Aguht5L639&ip={$get_ip}&coor=bd09ll");
		$json = json_decode($content, true);
		$lng = $json['content']['point']['x'];
		$lat = $json['content']['point']['y'];
		$city = $this->toAddressAmap($lng.','.$lat);
		$citys = $city["addressComponent"]["city"];
		$areas = $city["addressComponent"]["district"];
		echo $citys;
		echo "<br/>";
		echo $areas;
	}

	public function toAddressAmap($location){
		$key = '454e53aea79c0b9e75e22b2c14704a44';
		$url = "http://restapi.amap.com/v3/geocode/regeo?key=".$key."&location=".$location."&radius=1000&extensions=base&batch=false&roadlevel=0";
		$result = $this->liuyang_curl_get_contents($url);
		$result = json_decode($result, true);
		if($result['status'] == 1){
			return $result['regeocode'];
		}else{
			return $result['info'];
		}
	}

	function liuyang_curl_get_contents($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		$r = curl_exec($ch);
		curl_close($ch);
		return $r;
	}

	public function tts(){
		$str = file_get_contents("php://input");
	}
}