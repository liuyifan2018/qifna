<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/7/12
 * Time: 11:14
 */
namespace app\forum\controller;
use think\Controller;
use app\forum\Traits\User;
class Base extends Controller{

	use User{
		isUser as public;
		taskOutInfo as public;
	}

	public function initialize()
	{
		parent::initialize(); // TODO: Change the autogenerated stub
		self::isUser();
		self::taskOutInfo();
	}

}
