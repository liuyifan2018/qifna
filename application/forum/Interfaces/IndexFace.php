<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/6/21
 * Time: 10:38
 */
namespace app\forum\Interfaces;
interface IndexFace{

	/**
	 * @return mixed
	 * 首页
	 */
	public function index();

	/**
	 * @param $classify
	 * @return mixed
	 * 列表
	 */
	public function lists($classify);
	/**
	 * @param $title
	 * @return mixed
	 * 搜索帖子
	 */
	public function search($title);
}