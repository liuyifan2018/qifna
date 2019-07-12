<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/7/11
 * Time: 17:22
 */
namespace app\forum\Interfaces;
interface MessageFace{

	/**
	 * @return mixed
	 * 消息列表
	 */
	public function index();

	/**
	 * @param $data
	 * @return mixed
	 * 操作好友请求状态
	 */
	public function AgreeFriend($data);
}