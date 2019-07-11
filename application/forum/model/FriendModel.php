<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/7/11
 * Time: 10:13
 */
namespace app\forum\model;
use app\forum\Interfaces\FriendFace;
use app\forum\Traits\Date;
use app\forum\Traits\OutMsg;
use think\Db;
use think\facade\Cache;

class FriendModel extends BaseModel implements FriendFace {

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
	 * 我的好友
	 */
	public function friend(){
		$friendList = Db::name('forum_friend')->where(['username' => $this->data['username'],'is_friend' => 1])->select();
		if ($friendList != []){
			foreach ($friendList as &$item) {
				$friendInfo = Db::name('user')->where(['username' => $item['friend']])->field('state,name,insider')->find();//我的好友信息
				$item['state'] = $friendInfo['state'];
				$item['name']  = $friendInfo['name'];
				$item['insider'] = $friendInfo['insider'];
			}
		}
		$friendList == []?[]:$friendList;
		return OutMsg::outSuccessMsg($friendList);
	}

	/**
	 * @param $data
	 * @return mixed
	 * @throws \Exception
	 * 搜索用户的信息
	 */
	public function friendInfo( $data ){
		$this->is_empty($data['friend']);
		$friendInfo = Db::name('user')->where(['username' => $data['friend']])->find();
		if (empty($friendInfo)) {
			OutMsg::outErrorMsg("用户不存在!");
		}
		return OutMsg::outSuccessMsg($friendInfo);
	}

	/**
	 * @param $friend
	 * @return mixed
	 * @throws \Exception
	 * 添加好友
	 */
	public function addFriend($friend){
		if(Cache::get(md5($this->data['username'].'article'))){ //检测缓存是否存在
			return OutMsg::outErrorMsg("60s后才能重新请求!");
		}
		$this->is_empty($friend);
		$msg = [
			'username'  =>  $this->data['username'],
			'friend' => $friend,
			'is_friend' => 2,
			'date'  =>  Date::getNowTime()
		];
		$is_friend = Db::name('forum_friend')->where(['username' => $this->data['username'],'friend' => $friend])->find();
		if($this->data['username'] == $friend){
			return OutMsg::outErrorMsg('不能添加自己!');
		} elseif ($is_friend['is_friend'] == 1){
			return OutMsg::outErrorMsg('你们已是好友关系,请不要重复添加!');
		} elseif ($is_friend['is_friend'] == 2){
			return OutMsg::outSuccessMsg('请求已发送,请等待对方回应!');
		} elseif (empty($is_friend)){
			Db::name('forum_friend')->insert($msg);
			Cache::set(md5($this->data['username'].'article'),1,60);    //添加缓存
			return OutMsg::outSuccessMsg('发送成功,请等待对方回应!');
		} else{
			return OutMsg::outErrorMsg('添加失败!');
		}
	}
}