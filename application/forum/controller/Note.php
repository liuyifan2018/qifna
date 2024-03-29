<?php /** @noinspection PhpInconsistentReturnPointsInspection */

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/6/21
 * Time: 16:21
 */

namespace app\forum\controller;
use app\common\Date;
use app\common\OutMsg;
use app\forum\model\NoteModel;
use think\Db;
use think\facade\Request;
use app\forum\Traits\User;
use app\forum\Traits\CURD;

class Note extends Base
{
	/**
	 * 帖子操作控制器
	 */

	/**
	 * @var $model
	 * 公共模型
	 */
	protected $model;

	/**
	 * @var $data
	 * 用户信息
	 */
	protected $data;

	/**
	 * @var $param
	 * 接收参数
	 */
	protected $param;

	/**
	 * @var $classify
	 * 分类
	 */
	protected $classify;

	/**
	 * 初始化
	 */
	public function initialize()
	{
		parent::initialize(); // TODO: Change the autogenerated stub
		try {
			$data = User::dataInfo();
			$this->model = new NoteModel($data);
			$this->param = CURD::PurificationParam();
			$this->data = $data;
			$this->classify = \app\forum\Traits\Note::classify();
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
	}

	/**
	 * @param $data
	 * @return NoteModel
	 * @throws \Exception
	 */
	public function model($data)
	{
		return new NoteModel($data);
	}

	/**
	 * @return \think\response\View
	 * 帖子详情
	 */
	public function note()
	{
		try {
			if (Request::isGet()) {
				$data = input('get.id');
				$noteInfo = $this->model($this->data)->note($data);
				$n_id = $noteInfo['note']['id'];
				return view('note', [
					'note' => $noteInfo,
					'classify' => $this->classify,
					'data' => $this->data,
					'n_id' => $n_id
				]);
			} else {
				$this->error('参数错误!');
			}
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
	}

	/**
	 * return mixed|\think\response\View
	 * @throws \Exception
	 * 发布帖子
	 */
	public function addNote()
	{
		try {
			if (Request::isPost()) {
				$data = $this->param;
				$Message = $this->model($this->data)->addNote($data);
				return $Message;
			}
			return view('addNote', [
				'classify' => $this->classify,
				'data' => $this->data,
				'arr' => $this->classify
			]);
		} catch (\Exception $e) {
			return OutMsg::outAbnormalMsg($e->getMessage());
		}
	}

	/**
	 * @return mixed|\think\response\Json|\think\response\View
	 * @throws \Exception
	 * 编辑帖子
	 */
	public function editNote()
	{
		try {
			$id = input('get.id');
			if (Request::isPost()) {
				$data = $this->param;
				$Message = $this->model($this->data)->editNote($data);
				return $Message;
			}
			return view('editNote', [
				'n_id' => $id,
				'classify' => $this->classify,
				'data' => $this->data,
				'arr' => $this->classify
			]);
		} catch (\Exception $e) {
			return OutMsg::outAbnormalMsg($e->getMessage());
		}
	}

	/**
	 * @return mixed
	 * @throws \Exception
	 * 获取帖子信息
	 */
	public function noteInfo()
	{
		try {
			$id = input('get.id');
			$noteInfo = $this->model($this->data)->superInfo($id, null);
			$noteInfo['classifyTitle'] = Db::name('forum_classify')->where(['id' => $noteInfo['classify']])->value('title');
			return OutMsg::outSuccessMsg($noteInfo);
		} catch (\Exception $e) {
			return OutMsg::outAbnormalMsg($e->getMessage());
		}
	}

	/**
	 * @return mixed|\think\response\Json
	 * @throws \Exception
	 * 删除帖子
	 */
	public function delNote()
	{
		try {
			if (Request::isGet()) {
				$data = input('get.id');
				$Message = $this->model($this->data)->delNote($data);
				return $Message;
			}
		} catch (\Exception $e) {
			return OutMsg::outAbnormalMsg($e->getMessage());
		}
	}

	/**
	 * @return mixed|\think\response\Json
	 * @throws \Exception
	 * 评论列表
	 */
	public function commentLists()
	{
		try {
			if (Request::isGet()) {
				$n_id = input('get.n_id');
				$Message = $this->model($this->data)->commentLists($n_id);
				return $Message;
			}
		} catch (\Exception $e) {
			return OutMsg::outAbnormalMsg($e->getMessage());
		}
	}

	/**
	 * @return \think\response\Json
	 * @throws \Exception
	 * 评论帖子
	 */
	public function content()
	{
		try {
			if (Request::isPost()) {
				$data = $this->param;
				$data['date'] = Date::getNowTime();
				$data['username'] = $this->data['username'];
				$data['is_show'] = 1;
				$Message = $this->model($this->data)->content($data);
				return $Message;
			}
		} catch (\Exception $e) {
			return OutMsg::outAbnormalMsg($e->getMessage());
		}
	}

	/**
	 * @return mixed|\think\response\Json
	 * @throws \Exception
	 * 帖子点赞
	 */
	public function good()
	{
		try {
			if (Request::isGet()) {
				$data = $this->param;
				$Message = $this->model($this->data)->good($data);
				return $Message;
			}
		} catch (\Exception $e) {
			return OutMsg::outAbnormalMsg($e->getMessage());
		}
	}

	/**
	 * @return mixed|\think\response\Json|void
	 * @throws \Exception
	 * 举报帖子
	 */
	public function report()
	{
		try {
			if (Request::isPost()) {
				$data = $this->param;
				$data['date'] = Date::getNowTime();
				$data['username'] = $this->data['username'];
				$Message = $this->model($this->data)->report($data);
				return $Message;
			}
		} catch (\Exception $e) {
			return OutMsg::outAbnormalMsg($e->getMessage());
		}
	}

	/**
	 * @return mixed|\think\response\Json|void
	 * @throws \Exception
	 * 收藏帖子
	 */
	public function collNote()
	{
		try {
			if (Request::isGet()) {
				$data = input('get.');
				$data['date'] = Date::getNowTime();
				$data['username'] = $this->data['username'];
				$Message = $this->model($this->data)->collNote($data);
				return $Message;
			}
		} catch (\Exception $e) {
			return OutMsg::outAbnormalMsg($e->getMessage());
		}
	}

}