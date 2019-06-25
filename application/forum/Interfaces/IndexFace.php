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
	 * @param $classify
	 * @return mixed
	 * 首页
	 */
	public function index($classify);

	/**
	 * @param $title
	 * @return mixed
	 * 搜索帖子
	 */
	public function search($title);
}