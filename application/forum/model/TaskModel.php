<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/7/13
 * Time: 11:26
 */

namespace app\forum\model;

use app\forum\Interfaces\TaskFace;
use app\forum\Traits\OutMsg;
use think\Db;
use app\forum\Traits\Date;
use app\forum\Traits\User;


class TaskModel extends BaseModel implements TaskFace
{

	/**
	 * @var $data
	 * 用户信息
	 */
	protected $data;

	/**
	 * TaskModel constructor.
	 * @param $data
	 * @throws \Exception
	 */
	public function __construct($data)
	{
		parent::__construct($data);
		if (empty($data)) throw new \Exception('用户不存在!');
		$this->data = $data;
	}

	/**
	 * @return mixed
	 * @throws \Exception
	 * 任务进度数据
	 */
	public function task()
	{
		$task['width'] = 0;
		$arr = ['signed', 'note', 'content', 'good', 'recharge'];
		for ($i = 0; $i < count($arr); $i++) {
			$task[$arr[$i]] = "";  //初始值
		}
		$time = [Date::getNowStartTime(), Date::getNowEndTime()];
		$signed = Db::name('forum_signed')->where(['username' => $this->data['username']])->whereTime('date', 'between', $time)->select(); //检测今天是否签到
		if ($signed) {
			$task['signed'] = 1;
			$task['width'] = $task['width'] + 20;
		}
		$dayNote = Db::name('forum_note')->where(['username' => $this->data['username']])->whereTime('date', 'between', $time)->find();   //查询今天是否发过帖子
		if ($dayNote) {
			$task['note'] = 1;
			$task['width'] = $task['width'] + 20;
		}
		$dayContent = Db::name('forum_content')->where(['username' => $this->data['username']])->whereTime('date', 'between', $time)->find();   //查询今天是否评论过
		if ($dayContent) {
			$task['content'] = 1;
			$task['width'] = $task['width'] + 20;
		}
		$dayGood = Db::name('forum_good')->where(['username' => $this->data['username']])->whereTime('date', 'between', $time)->find();   //查询今天是否点过赞
		if ($dayGood) {
			$width['good'] = 1;
			$task['width'] = $task['width'] + 20;
		}
		$dayRecharge = Db::name('forum_recharge')->where(['username' => $this->data['username']])->whereTime('date', 'between', $time)->find();   //查询今天是否充值
		if ($dayRecharge) {
			$task['recharge'] = 1;
			$task['width'] = $task['width'] + 20;
		}
		return OutMsg::outSuccessMsg($task);
	}

	/**
	 * @return mixed
	 * @throws \Exception
	 * 领取奖品
	 */
	public function getReward()
	{
		$time = [Date::getNowStartTime(), Date::getNowEndTime()];
		$signed = Db::name('forum_signed')->where(User::username())->whereTime('date', 'between', $time)->find(); //检测今天是否签到
		$dayNote = Db::name('forum_note')->where(User::username())->whereTime('date', 'between', $time)->find();   //查询今天是否发过帖子
		$dayContent = Db::name('forum_content')->where(User::username())->whereTime('date', 'between', $time)->find();   //查询今天是否评论过
		$dayGood = Db::name('forum_good')->where(User::username())->whereTime('date', 'between', $time)->find();   //查询今天是否点过赞
		$dayRecharge = Db::name('forum_recharge')->where(User::username())->whereTime('date', 'between', $time)->find();   //查询今天是否充值
		$arr = [$signed, $dayNote, $dayContent, $dayGood, $dayRecharge];
		for ($i = 0; $i < count($arr); $i++) {
			if (empty($arr[$i])) {
				return OutMsg::outErrorMsg("领取失败,请做完任务再领取!");
			}
		}
		switch ($this->data['task']) {
			case 1:
				return OutMsg::outErrorMsg("你已领取过,请不要重复!");
				break;
			case 0:
				Db::name('user')->where(User::username())->update(['task' => 1]);
				Db::name('user')->where(User::username())->setInc('money', 100);
				return OutMsg::outSuccessMsg("领取成功,恭喜你获得100金币!");
				break;
			default:
				null;
		}
	}
}