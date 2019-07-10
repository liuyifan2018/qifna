<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/7/8
 * Time: 15:14
 */

namespace app\forum\model;

use app\forum\Interfaces\DataFace;
use app\forum\Traits\OutMsg;
use think\Db;
use think\facade\Cache;
use app\forum\Traits\Date;

class DataModel extends BaseModel implements DataFace
{

	/**
	 * @var $data
	 * 用户资料
	 */
	protected $data;

	/**
	 * DataModel constructor.
	 * @param $data
	 * @throws \Exception
	 */
	public function __construct($data)
	{
		parent::__construct($data);
		if (empty($data)) throw new \Exception('用户未登录!');
		$this->data = $data;
	}

	/**
	 * @param $username
	 * @return mixed
	 * @throws \Exception
	 */
	public function index($username)
	{
		$user = Db::name('user')->where(['username' => $username])->find();
		if (empty($user)) throw new \Exception('用户不存在!');
		return $user;
	}

	/**
	 * @param $start_time
	 * @param $end_time
	 * @param $msg
	 * @return mixed
	 * @throws \Exception
	 */
	public function signed($start_time, $end_time, $msg)
	{
		$signed = Db::name('forum_signed')->where(['username' => $msg['username']])->whereTime('date', 'between', array($start_time, $end_time))->select(); //检测今天是否签到
		if ($signed == NULL) {    //没有签到
			Db::name('forum_signed')->where(['username' => $msg['username']])->strict(false)->insert($msg);  //记录签到
			Db::name('user')->where(['username' => $msg['username']])->setInc('money', $msg['money']);//连续签到增长
			return OutMsg::outSuccessMsg('签到成功!');
		} else {  //已签到
			return OutMsg::outSuccessMsg('你今天已签到!');
		}
	}

	/**
	 * @param $username
	 * @return mixed
	 * @throws \Exception
	 */
	public function user($username)
	{
		$this->is_empty($username);
		$user['user'] = Db::name('user')->where(['username' => $username])->find();
		$user['note'] = Db::name('forum_note')->where(['username' => $username, 'is_show' => 1])->select();  //用户发布的帖子
		foreach ($user['note'] as &$item) {
			$item['count'] = Db::name('forum_content')->where(['n_id' => $item['id']])->count();
		}
		$user['content'] = Db::name('forum_content')->where(['username' => $username])->select();   //用户评论信息
		$user['count'] = count($user['content']);
		foreach ($user['content'] as &$item) {
			$note = Db::name('forum_note')->where(['id' => $item['n_id']])->field('id,title')->find();
			$item['name'] = Db::name('user')->where(['username' => $item['username']])->value('name');
			$item['note'] = $note['title'];    //帖子标题
			$item['noteid'] = $note['id']; //帖子ID
		}
		if (empty($user)) throw new \Exception('用户不存在!');
		return $user;
	}

	/**
	 * @param $data
	 * @return mixed
	 * @throws \Exception
	 * 更新用户资料
	 */
	public function editUser($data)
	{
		if (Cache::get(md5($this->data['username'] . 'article'))) { //检测缓存是否存在
			return OutMsg::outErrorMsg("修改频繁,请稍后重试!");
		}
		$arr = ['phone', 'email', 'name', 'city', 'auto'];
		$this->Handle($data, $arr);
		Cache::set(md5($this->data['username'] . 'article'), 1, 30);    //添加缓存
		$update = Db::name('user')->where(['username' => $this->data['username']])->update(['password' => $data['pass']]);
		if ($update === false) {
			return OutMsg::outErrorMsg("更新失败!");
		}
		return OutMsg::outSuccessMsg("更新成功!");
	}

	/**
	 * @param $uid
	 * @param $image
	 * @throws \Exception
	 * 上传图片
	 */
	public function upImage($uid, $image)
	{
		if (empty($uid)) throw new \Exception('参数错误!');
		$image = "http://localhost/Qifan/uploads/" . $image;
		$upImage = Db::name('user')
			->where(['id' => $uid])
			->update(['img' => $image]);
		if ($upImage) {
			throw new \Exception('上传成功!');
		} else {
			throw new \Exception('上传失败!');
		}
	}

	/**
	 * @param $data
	 * @return mixed
	 * @throws \Exception
	 * 修改密码
	 */
	public function updatePass($data)
	{
		if (Cache::get(md5($this->data['username'] . 'article'))) { //检测缓存是否存在
			return OutMsg::outErrorMsg("修改频繁,请稍后重试!");
		}
		if ($this->data['password'] != $data['pass']) throw new \Exception('密码错误!');
		$arr = ['pass', 'repass'];
		$this->Handle($data, $arr);
		Cache::set(md5($this->data['username'] . 'article'), 1, 30);    //添加缓存
		$upPass = Db::name('user')->where(['username' => $this->data['username']])->update(['password' => $data['pass']]);
		if ($upPass === false) {
			return OutMsg::outErrorMsg('修改失败!');
		}
		return OutMsg::outSuccessMsg('修改成功!');
	}

	/**
	 * @return mixed
	 * 我的帖子
	 */
	public function note()
	{
		$note['note'] = Db::name('forum_note')
			->where(['username' => $this->data['username']])
			->select(); //我发布的帖子
		$note['coll'] = Db::name('forum_coll')
			->where(['username' => $this->data['username'], 'coll' => 1])
			->select(); //我收藏的帖子
		foreach ($note['coll'] as &$item) {
			$item['title'] = Db::name('forum_note')->where(['id' => $item['n_id']])->value('title'); //收藏帖子的标题
		}
		foreach ($note['note'] as &$item) {
			$item['count'] = Db::name('forum_content')->where(['n_id' => $item['id']])->count(); //我的帖子评论总数
		}
		return $note;
	}

	/**
	 * @param $data
	 * @return mixed
	 * @throws \Exception
	 * 帖子是否隐藏
	 */
	public function is_show($data)
	{
		$this->is_empty($data['id']);
		Db::name('forum_note')->where(['id' => $data['id']])->update(['is_show' => $data['type']]);
		switch ($data['type']) {
			case 1:
				return OutMsg::outSuccessMsg('已上架!');
				break;
			case 2:
				return OutMsg::outSuccessMsg('已下架!');
				break;
			default:
				return OutMsg::outErrorMsg('操作失败!');
		}
	}

	/**
	 * @param $data
	 * @return mixed
	 * @throws \Exception
	 * 充值余额
	 */
	public function recharge( $data ){
		if ($data['money'] == "") return OutMsg::outErrorMsg('请填写充值金额!');
		$recharge = [
			'money' =>  $data['money'],
			'username'  =>  $this->data['username'],
			'date'  =>  Date::getNowTime()
		];
		Db::startTrans();
		Db::name('forum_recharge')->strict(false)->insert($recharge);//充值日志
		$update =  Db::name('user')
			->where(['username' => $this->data['username']])
			->setInc('money',$data['money']);    //充值余额
		Db::commit();
		if ($update === false){
			Db::rollback();
			return OutMsg::outErrorMsg("充值失败!");
		}
		return OutMsg::outSuccessMsg('充值成功!');
	}

	/**
	 * @param $data
	 * @return mixed
	 * @throws \Exception
	 * 开通会员
	 */
	public function insider( $data ){
		$nameArr = ['普通会员','黄金会员','钻石会员','至尊会员'];
		$map = array(
			'insider' => $name = $nameArr[$data['name']],
			'last_insider' => Date::getNowTime()+2592000
		);
		if ($this->data['money'] < $data['money']){
			return OutMsg::outErrorMsg("余额不足!");
		}
		Db::startTrans();
		$update = Db::name('user')->where(['username' => $this->data['username']])->update($map); //相对会员相对金额
		Db::name('user')->where(['username' => $this->data['username']])->setDec('money',$data['money']);
		Db::commit();
		if ($update === false){
			Db::rollback();
			return OutMsg::outErrorMsg("开通失败!");
		}
		return OutMsg::outSuccessMsg("开通成功!");
	}

}