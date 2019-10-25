<?php
/**
 * @author liuyifan
 * @createTime 2019/10/20 11:32 PM
 */

namespace app\widget\template;

/**
 * 保姆模板
 * Class Nanny
 * @package app\widget\template
 */
class Nanny implements Template
{


	/**
	 * @param string $query
	 * @return false|mixed|string
	 */
	public function widgetData($query) {
		$data = json_encode([
			"err_code"  => 0,
			"err_msg"   => "success",
			"img_url"   => $this->image(),
			"jump_url"  => $this->jumpUrl(),
			"service_name"   => $this->serviceName(),
			"type"      => $this->type(),
			"skil_list" => $this->skilList(),
			"price"     => $this->price(),
			"license_list" => ["身份证", "营业执照"]
		]);
		return $data;
	}

	/************************ 必须实现方法 *************************/

	public function image() {
		return "http://xrs.tupiancunchu.com/2019-10-22_5dae74634c86f.png";
	}

	public function price() {
		return "下单预约金 ￥5";
	}

	public function serviceName() {
		return "保姆服务";
	}

	public function jumpUrl() {
		return "pages/service/serviceList/serviceList?id=22623";
	}

	/************************* 模板需求方法 **************************/

	/**
	 * @return array
	 */
	public function type() {
		return ["月嫂", "保姆", "育儿嫂"];
	}

	/**
	 * @return array
	 */
	public function skilList() {
		return ["营养餐", "做饭", "早期教育"];
	}

	public function fixedData(){
		$data = json_encode([
			"err_code"  => 0,
			"err_msg"   => "success",
			"img_url"   => "http://xrs.tupiancunchu.com/2019-10-22_5dae74634c86f.png",
			"jump_url"  => "pages/service/serviceList/serviceList?id=22623",
			"service_name"   => "保姆服务",
			"type"      => ["月嫂", "护工", "产妇护理"],
			"skil_list" => ["做饭", "照顾老人", "早期教育"],
			"price"     => "下单预约金 ￥5",
			"license_list" => ["身份证", "营业执照"]
		]);
		return $data;
	}
}
//http://xrs.tupiancunchu.com/2019-09-25_5d8b24f481c83.png