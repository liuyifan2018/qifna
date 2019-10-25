<?php
/**
 * @author liuyifan
 * @createTime 2019/10/20 11:32 PM
 */

namespace app\widget\template;

/**
 * 保洁模板
 * Class Nanny
 * @package app\widget\template
 */
class Cleaning implements Template
{


	/**
	 * @param string $query
	 * @return false|mixed|string
	 */
	public function widgetData($query) {
		$data = [
			"err_code"  => 0,
			"err_msg"   => "success",
			"img_url"   => $this->image(),
			"jump_url"  => $this->jumpUrl(),
			"service"   => $this->serviceName(),
			"type"      => $this->type(),
			"skil_list" => $this->skilList(),
			"price"     => $this->price()
		];
		return json_encode($data);
	}

	/************************ 必须实现方法 *************************/

	public function image() {
		return "http://xrs.tupiancunchu.com/2019-09-25_5d8b24f481c83.png";
	}

	public function price() {
		return "定价五元";
	}

	public function serviceName() {
		return "保洁清洗";
	}

	public function jumpUrl() {
		return "pages/service/serviceList/serviceList?id=22614";
	}

	/************************* 模板需求方法 **************************/

	/**
	 * @return array
	 */
	public function type() {
		return ["打扫卫生", "清洁工", "新房开荒"];
	}

	/**
	 * @return array
	 */
	public function skilList() {
		return ["新房打扫", "开荒保洁", "保洁小时工"];
	}
}