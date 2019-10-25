<?php

namespace app\admin\service\user\message;

use app\admin\model\User;

class SendMessage
{

	public $type = [
		0	=>	'奖励',
		1	=>	'惩罚',
		2	=>	'通知'
	];

	/**
	 * 1未读 2已读
	 * @var int
	 */
	public $is_look = 1;

	/**
	 * 发布通知
	 * @param $lists
	 * @param $data
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public static function sendMessage($lists,$data) {
		if (empty($lists)) { //自生成列表
			$lists = User::field('id')->select();
		}
		$data['create_time'] = time();
		$data['is_del']	=	0;
		foreach ($lists as $k => $v) {
			$data['uid'] = $v['id'];
			User::insert($data);
		}
	}

	/**
	 * 给用户发信息
	 * @param $data
	 * @return bool
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public static function sendUserMessage($data){
		$lists = User::field('id')->select();
		foreach ($lists as $k => $v){
			if ($v['id'] == $data['uid']){
				User::insert($data);
				return true;
			}
		}
		throw new \Exception('用户不存在!');
	}
}