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

class DataModel extends BaseModel implements DataFace{

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
	public function index( $username )
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
	public function signed($start_time,$end_time,$msg){
		$signed = Db::name('forum_signed')->where(['username' => $msg['username']])->whereTime('date','between',array($start_time , $end_time))->select(); //检测今天是否签到
		if($signed == NULL){    //没有签到
			Db::name('forum_signed')->where(['username' => $msg['username']])->strict(false)->insert($msg);  //记录签到
			Db::name('user')->where(['username' => $msg['username']])->setInc('money',$msg['money']);//连续签到增长
			return OutMsg::outSuccessMsg('签到成功!');
		}else{  //已签到
			return OutMsg::outSuccessMsg('你今天已签到!');
		}
	}

	/**
	 * @param $username
	 * @return mixed
	 * @throws \Exception
	 */
	public function user($username){
		$this->is_empty($username);
		$user['user'] = Db::name('user')->where(['username' => $username])->find();
		$user['note'] = Db::name('forum_note')->where(['username' => $username,'is_show' => 1])->select();  //用户发布的帖子
		foreach ($user['note'] as &$item){
			$item['count'] = Db::name('forum_content')->where(['n_id' => $item['id']])->count();
		}
		$user['content'] = Db::name('forum_content')->where(['username' => $username])->select();   //用户评论信息
		$user['count'] = count($user['content']);
		foreach($user['content'] as &$item){
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
	public function editUser( $data ){
		if(Cache::get(md5($this->data['username'].'article'))){ //检测缓存是否存在
			return OutMsg::outErrorMsg("修改频繁,请稍后重试!");
		}
		$arr = ['phone','email','name','city','auto'];
		$this->Handle($data,$arr);
		Cache::set(md5($this->data['username'].'article'),1,30);    //添加缓存
		$update = Db::name('user')->where(['username' => $this->data['username']])->update(['password' => $data['pass']]);
		if ($update === false){
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
	public function upImage($uid,$image){
		if(empty( $uid )) throw new \Exception('参数错误!');
		$image = "http://localhost/Qifan/uploads/" . $image;
		$upImage = Db::name('user')
			->where(['id' => $uid])
			->update(['img' => $image]);
		if($upImage){
			throw new \Exception('上传成功!');
		}else{
			throw new \Exception('上传失败!');
		}
	}


	public function updatePass( $data ){
		if(Cache::get(md5($this->data['username'].'article'))){ //检测缓存是否存在
			return OutMsg::outErrorMsg("修改频繁,请稍后重试!");
		}
		$arr = ['pass','repass'];
		$this->Handle($data);
		Cache::set(md5($this->data['username'].'article'),1,30);    //添加缓存
	}


}