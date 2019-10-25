<?php
/**
 * @author liuyifan
 * @createTime 2019/10/20 11:23 PM
 */
namespace app\widget\template;

/**
 * 模板接口类
 * Interface Template
 * @package app\widget\template
 */
interface Template{

	/**
	 * 返回数据方法
	 * @param $query string 模板信息关键字
	 * @return mixed
	 */
	public function widgetData($query);

	/**
	 * 模板服务名称
	 * @param $kid
	 * @return mixed
	 */
	public function serviceName();

	/**
	 * 模板图片
	 * @param $kid
	 * @return mixed
	 */
	public function image();

	/**
	 * 模板显示价钱
	 * @param $kid
	 * @return mixed
	 */
	public function price();

	/**
	 * 小程序跳转路径
	 * @param $kid
	 * @return mixed
	 */
	public function jumpUrl();
}