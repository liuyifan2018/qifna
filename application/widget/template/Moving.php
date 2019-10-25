<?php
/**
 * @author liuyifan
 * @createTime 2019/10/20 11:32 PM
 */

namespace app\widget\template;

/**
 * 搬家模板
 * Class Nanny
 * @package app\widget\template
 */
class Moving implements Template
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
		return "搬家服务";
	}

	public function jumpUrl() {
		return "pages/service/serviceList/serviceList?id=17";
	}

	/************************* 模板需求方法 **************************/

	/**
	 * @return array
	 */
	public function type() {
		return ["居民搬家", "同城拉货", "空调移机"];
	}

	/**
	 * @return array
	 */
	public function skilList() {
		return ["公司搬迁", "拉货", "搬货"];
	}
}