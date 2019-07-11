<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/7/11
 * Time: 10:13
 */
namespace app\forum\Interfaces;
interface FriendFace{

	/**
	 * @return mixed
	 * 查找自己的好友
	 */
	public function friend();

	/**
	 * @param $friend
	 * @return mixed
	 * 查找好友
	 */
	public function friendInfo($friend);

	/**
	 * @param $friend
	 * @return mixed
	 * 添加好友
	 */
	public function addFriend($friend);
}