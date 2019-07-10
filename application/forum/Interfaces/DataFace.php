<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/7/8
 * Time: 15:13
 */
namespace app\forum\Interfaces;
interface DataFace{

	/**
	 * @param $username
	 * @return mixed
	 * 个人信息主页
	 */
	public function index( $username );

	/**
	 * @param $start_time
	 * @param $end_time
	 * @param $msg
	 * @return mixed
	 * 签到
	 */
	public function signed( $start_time,$end_time,$msg );

	/**
	 * @param $username
	 * @return mixed
	 * 用户信息
	 */
	public function user($username);

	/**
	 * @param $data
	 * @return mixed
	 * 修改资料
	 */
	public function editUser($data);

	/**
	 * @param $uid
	 * @param $image
	 * @return mixed
	 * 上传头像
	 */
	public function upImage($uid,$image);

	/**
	 * @param $data
	 * @return mixed
	 * 修改密码
	 */
	public function updatePass( $data );

	/**
	 * @return mixed
	 * 我的帖子
	 */
	public function note();

	/**
	 * @param $data
	 * @return mixed
	 * 是否隐藏
	 */
	public function is_show( $data );

	/**
	 * @param $data
	 * @return mixed
	 * 充值
	 */
	public function recharge( $data );

	/**
	 * @param $data
	 * @return mixed
	 * 开通会员
	 */
	public function insider( $data );
}