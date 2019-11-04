<?php
/**
 * @author liuyifan
 * @createTime 2019/10/20 11:32 PM
 */

namespace app\widget\template;

/**
 * 家电清洗模板
 * Class Nanny
 * @package app\widget\template
 */
class Electric implements Template
{


	/**
	 * @param string $query
	 * @return false|mixed|string
	 */
	public function widgetData($query) {
		$data = [
			"err_code"             => 0,
			"err_msg"              => "success",
			"jump_url"             => $this->jumpUrl(),
			"address_desc"         => $this->getlatInfo(),
			"business_result_list" => [
				[
					"jump_url"  => "",
					"img_url"   => "",
					"title"     => "马桶疏通",
					"sales"     => "已售1000+",
					"abstracts" => "专业马桶疏通,最快30分钟上门"
				],
				[
					"jump_url"  => "",
					"img_url"   => "",
					"title"     => "管道疏通",
					"sales"     => "已售1000+",
					"abstracts" => "快速上面,价格明透"
				]
			],
			"footer_desc"	=>	'点击查看更多服务'
		];
		return json_encode($data);
	}

	public function getlatInfo() {
		header("content-type:text/html;charset=utf-8");
		$get_ip = $_SERVER['REMOTE_ADDR'];
		$content = file_get_contents("http://api.map.baidu.com/location/ip?ak=Gi1nULBk8PY6PdBVyqnrT8Aguht5L639&ip={$get_ip}&coor=bd09ll");
		$json = json_decode($content, true);
		$lng = $json['content']['point']['x'];
		$lat = $json['content']['point']['y'];
		$city = $this->toAddressAmap($lng . ',' . $lat);
		$citys = $city["addressComponent"]["city"];
		return $citys;
	}

	public function toAddressAmap($location) {
		$key = '454e53aea79c0b9e75e22b2c14704a44';
		$url = "http://restapi.amap.com/v3/geocode/regeo?key=" . $key . "&location=" . $location . "&radius=1000&extensions=base&batch=false&roadlevel=0";
		$result = $this->liuyang_curl_get_contents($url);
		$result = json_decode($result, true);
		if ($result['status'] == 1) {
			return $result['regeocode'];
		} else {
			return $result['info'];
		}
	}


	function liuyang_curl_get_contents($url) {
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

	/************************ 必须实现方法 *************************/

	public function image() {
		return "http://xrs.tupiancunchu.com/2019-09-25_5d8b24f481c83.png";
	}

	public function price() {
		return "定价五元";
	}

	public function serviceName() {
		return "家电清洗";
	}

	public function jumpUrl() {
		return "pages/service/serviceList/serviceList?id=22635";
	}

	/************************* 模板需求方法 **************************/

	/**
	 * @return array
	 */
	public function type() {
		return ["清洗家电", "空调清洗", "洗衣机清洗"];
	}

	/**
	 * @return array
	 */
	public function skilList() {
		return ["冰箱清洗", "热水器清洗", "油烟机清洗"];
	}
}