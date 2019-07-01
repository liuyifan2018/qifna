<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/6/21
 * Time: 16:21
 */
namespace app\forum\model;
use app\forum\Interfaces\NoteFace;
use app\forum\Traits\CURD;
use app\forum\Traits\Date;
use app\forum\Traits\OutMsg;
use think\Db;
use think\Model;
class NoteModel extends Model implements NoteFace {

	/**
	 * @var $data
	 * 用户信息
	 */
	protected $data;

	/**
	 * NoteModel constructor.
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
	 * @param $id
	 * @return mixed
	 * @throws \Exception
	 * 帖子详情
	 */
	public function note( $id )
	{
		if (empty($id)) throw new \Exception('帖子不存在!');
		$note['note'] = $this->superInfo( $id ,''); //获取帖子信息
		Db::table('forum_note')->where(array('id' => $id))->setInc('num');    //增加浏览量
		return $note;
	}


	/**
	 * @param $data
	 * @return mixed
	 * @throws \Exception
	 * 发布帖子
	 */
	public function addNote($data)
	{
		Db::transaction(function(){
			$data['date'] = Date::getNowTime();
			$data['username'] = $this->data['username'];
			$arr = ['title','content','classify','money'];
			for ($i = 0; $i < count($arr); $i++){
				if($data[$arr[$i]] == ""){
					return OutMsg::outErrorMsg("必填项不能为空!");
				}
			}
			if ($this->data['money'] < $data['money']){
				return OutMsg::outErrorMsg("余额不足!");
			}
			Db::name('user')->where(['username' => $this->data['username']])->setDec('money',$data['money']);
			$add = Db::table('forum_note')->insert($data);
			if ($add === false){
				return OutMsg::outErrorMsg("发布失败!");
			}
		});
		return OutMsg::outSuccessMsg("发布成功!");
	}

	/**
	 * @param $data
	 * @return mixed
	 * @throws \Exception
	 * 编辑帖子
	 */
	public function editNote($data)
	{
		$arr = ['title','content','classify','money'];
		for ($i = 0; $i < count($arr); $i++){
			if($data[$arr[$i]] == "") return OutMsg::outErrorMsg("必填项不能为空!");
		}
		if ($this->data['money'] < $data['money']){
			return OutMsg::outErrorMsg("余额不足!");
		}
		$edit = Db::table('forum_note')->where(['id' => $data['id']])->update($data);
		if ($edit === false){
			return OutMsg::outErrorMsg("发布失败!");
		}
		return OutMsg::outSuccessMsg("发布成功!");
	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws \Exception
	 * 删除帖子
	 */
	public function delNote($id)
	{
		if (empty($id) || !is_numeric($id)) return OutMsg::outErrorMsg('参数错误!');
		$del = Db::name('forum_note')->where(['id' => $id])->delete();
		if ($del === false){
			return OutMsg::outErrorMsg('删除失败!');
		}
		return OutMsg::outSuccessMsg('删除成功!');
	}

	/**
	 * @param $id
	 * @param $value
	 * @return mixed
	 * @throws \Exception
	 * 终极方法,获取单个或全部的数据
	 */
	public function superInfo( $id, $value )
	{
		$keys = CURD::getModelInfo('forum_note'); //获取全部字段
		if (empty($value)){
			unset($value);
			$note = Db::table('forum_note')->where(['id' => $id])->find();
		}else{
			if(!in_array($value,$keys)) {
				throw new \Exception('字段不存在!');
			}
			$note = Db::table('forum_note')->where(['id' => $id])->value($value);
		}
		return $note;
	}

	/**
	 * @param $data
	 * @return mixed
	 * @throws \Exception
	 * 评论帖子
	 */
	public function content($data)
	{
		if (empty($data['n_id']) || !is_numeric($data['n_id'])) return OutMsg::outErrorMsg('帖子不存在!');
		if (empty($data['content'])) return OutMsg::outErrorMsg('评论内容不能为空!');
		if (strlen($data['content']) < 10 || strlen($data['content']) > 255) return OutMsg::outErrorMsg('评论内容限制在10-255字内');
		$addContent = Db::name('forum_content')->insert($data);
		if ($addContent === false){
			return OutMsg::outSuccessMsg('评论失败!');
		}
		return OutMsg::outSuccessMsg('评论成功!');
	}

	/**
	 * @param $data
	 * @return mixed
	 * @throws \Exception
	 * 帖子点赞
	 */
	public function good($data)
	{
		if (empty($data['n_id']) || !is_numeric($data['n_id'])) return OutMsg::outErrorMsg('帖子不存在!');
		$map = [
			'username' => $this->data['username'],
			'n_id'  =>  $data['n_id']
		];
		$is_good = Db::name('forum_good')->where($map)->find();
		if(!empty($is_good)){
			return OutMsg::outErrorMsg('不能重复点赞!');
		}
		$good = Db::name('forum_good')->strict(false)->insert($data);
		if ($good === false){
			return OutMsg::outErrorMsg('点赞失败!');
		}
		return OutMsg::outSuccessMsg('点赞成功!');
	}

	/**
	 * @param $data
	 * @return mixed
	 * @throws \Exception
	 * 举报帖子
	 */
	public function report($data)
	{
		if (empty($data['n_id']) || !is_numeric($data['n_id'])) return OutMsg::outErrorMsg('帖子不存在!');
		if (strlen($data['content']) < 10 || strlen($data['content']) > 255) return OutMsg::outErrorMsg('举报内容限制在10-255字内');
		$map = [
			'username' => $this->data['username'],
			'n_id'  =>  $data['n_id']
		];
		$is_report = Db::name('forum_report')->where($map)->find();
		if(!empty($is_report)){
			return OutMsg::outErrorMsg('不能重复举报!');
		}
		$report = Db::name('forum_good')->strict(false)->insert($data);
		if ($report === false){
			return OutMsg::outErrorMsg('举报失败!');
		}
		return OutMsg::outSuccessMsg('举报成功!');
	}
}