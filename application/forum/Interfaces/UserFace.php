<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/6/21
 * Time: 10:40
 */
namespace app\forum\Interfaces;
interface UserFace{

	/**
	 * @param $data
	 * @return mixed
	 * 登录
	 */
	public function login( $data );

	/**
	 * @param $data
	 * @return mixed
	 * 注册
	 */
	public function register( $data );

	/**
	 * @param $data
	 * @return mixed
	 * 注销
	 */
	public function loginOut( $data );
}