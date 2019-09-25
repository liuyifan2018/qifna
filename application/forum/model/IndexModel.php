<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/6/21
 * Time: 10:38
 */
namespace app\forum\model;
use app\forum\Interfaces\IndexFace;
use app\forum\Traits\Note;
use app\common\OutMsg;
use think\Db;
class IndexModel extends BaseModel implements IndexFace {

	/**
	 * @var $data
	 * 用户信息
	 */
	protected $data;

	/**
	 * @var array
	 * 判断条件
	 */
	protected $map = [];

	/**
	 * IndexModel constructor.
	 * @param $data
	 * @throws \Exception
	 */
	public function __construct($data)
	{
		parent::__construct($data);
		if (empty($data)) throw new \Exception('用户未登录!');
		$this->data = $data;
		$this->map = ['is_show' => 1, 'state' => 1];
	}

	public function index()
	{
		$lists['hotNote'] = Note::hotNote($this->map);  //最火的帖子
		return $lists;
	}

	/**
	 * @param $classify
	 * @return mixed
	 * @throws \Exception
	 */
	public function lists( $classify ){
		if (!empty($classify)){
			$lists = Db::name('forum_note')->where($this->map)->where(['classify' => $classify])->select();
		}else{
			$lists = Db::name('forum_note')->where($this->map)->select();
		}
		foreach ($lists as $k => $v){
			$lists[$k]['classify'] = Db::name('forum_classify')->where(['id' => $v['classify']])->value('title');
			$userInfo = Db::name('user')->where(['username' => $v['username']])->field('name,img')->find();
			$lists[$k]['name'] = $userInfo['name'];
			$lists[$k]['user_photo'] = $userInfo['img'];
			$lists[$k]['date']  = date('Y-m-d H:i:s',$v['date']);
		}
		return OutMsg::outSuccessMsg($lists);
	}

	public function search($title)
	{
		// TODO: Implement search() method.
	}
}