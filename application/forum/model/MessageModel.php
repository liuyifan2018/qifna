<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/7/11
 * Time: 17:22
 */

namespace app\forum\model;

use app\forum\Interfaces\MessageFace;
use app\forum\Traits\OutMsg;
use think\Db;

class MessageModel extends BaseModel implements MessageFace
{

	/**
	 * @var $data
	 * 用户信息
	 */
	protected $data;

	public function __construct($data)
	{
		parent::__construct($data);
		if (empty($data)) throw new \Exception('用户未登录!');
		$this->data = $data;
	}

	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public function index()
	{
		$message['fsg'] = Db::name('forum_friend')->where(['friend' => $this->data['username'], 'is_friend' => 2])->select();
		$message['csg'] = Db::name('forum_content')->where(['is_show' => 1])->whereOr(['username' => $this->data['username']])->select();
		$message['rsg'] = Db::name('forum_friend')->where(['friend' => $this->data['username']])->where('is_friend', '<>', 3)->select();
		foreach ($message['fsg'] as &$item) { //用户添加我的信息
			$item['name'] = Db::name('user')->where(['username' => $item['username']])->value('name');
		}
		foreach ($message['csg'] as &$item) { //用户评论我帖子的信息
			$user = Db::name('user')->where(['username' => $item['username']])->field('name,username')->find();
			$item['name'] = $user['name'];
			$item['username'] = $user['username'];
			$item['title'] = Db::name('forum_note')->where(['id' => $item['n_id']])->value('title');   //帖子标题
		}
		foreach ($message['rsg'] as &$item) { //用户拒绝我的请求信息
			$item['name'] = Db::name('user')->where(['username' => $item['username']])->value('name');
		}
		return $message;
	}

	/**
	 * @return mixed
	 * @throws \Exception
	 * 消息列表
	 */
	public function messageList(){
		$message['fsg'] = Db::name('forum_friend')->where(['friend' => $this->data['username'], 'is_friend' => 2])->select();
		$message['csg'] = Db::name('forum_content')->where(['is_show' => 1])->whereOr(['username' => $this->data['username']])->select();
		$message['rsg'] = Db::name('forum_friend')->where(['friend' => $this->data['username'],'type' => 2])->select();
		foreach ($message['fsg'] as &$item) { //用户添加我的信息
			$item['name'] = Db::name('user')->where(['username' => $item['username']])->value('name');
			$item['date'] = date('Y-m-d H:i:s',$item['date']);
		}
		foreach ($message['csg'] as &$item) { //用户评论我帖子的信息
			$user = Db::name('user')->where(['username' => $item['username']])->field('name,username')->find();
			$item['name'] = $user['name'];
			$item['username'] = $user['username'];
			$item['title'] = Db::name('forum_note')->where(['id' => $item['n_id']])->value('title');   //帖子标题
		}
		foreach ($message['rsg'] as &$item) { //用户拒绝我的请求信息
			$item['name'] = Db::name('user')->where(['username' => $item['username']])->value('name');
		}
		return OutMsg::outSuccessMsg($message);
	}

	/**
	 * @param $data
	 * @return mixed
	 * @throws \Exception
	 */
	public function AgreeFriend($data)
	{
		$code['is_friend'] = $code['type'] = $data['type'];
		$this->is_empty($data['username']);
		if (empty($data['type'])) return OutMsg::outErrorMsg('参数错误!');
		Db::name('forum_friend')
			->where(['friend' => $this->data['username'], 'username' => $data['username']])
			->update($code); //通过验证加为好友
		Db::name('forum_friend')
			->where(['username' => $this->data['username'], 'friend' => $data['username']])
			->update($code); //通过验证加为好友
		switch ($data['type']) {
			case 1:
				return OutMsg::outSuccessMsg('添加成功!');
				break;
			case 2:
				return OutMsg::outSuccessMsg('已拒绝!');
				break;
			case 3:
				return OutMsg::outSuccessMsg('已忽略!');
				break;
		}
	}
}