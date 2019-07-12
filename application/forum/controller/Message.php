<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/7/11
 * Time: 17:16
 */
namespace app\forum\controller;
use app\forum\model\MessageModel;
use app\forum\Traits\CURD;
use app\forum\Traits\OutMsg;
use app\forum\Traits\User;
use app\forum\Traits\Note;
use think\facade\Request;

class Message extends Base{

	/**
	 * @var $data
	 * 用户信息
	 */
	protected $data;

	/**
	 * @var $model
	 * 公共模型
	 */
	protected $model;

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
		try{
			$data = User::dataInfo();
			$this->model = new MessageModel($data);
			$this->data = $data;
			$this->param = CURD::PurificationParam();
			$this->classify = Note::classify();
		}catch (\Exception $e){
			$this->error( $e->getMessage() );
		}
	}

	/**
	 * @param $data
	 * @return MessageModel
	 * @throws \Exception
	 */
	public function model($data){
		return new MessageModel($data);
	}

	/**
	 * @return \think\response\View
	 */
	public function index(){
		try{
			$message = $this->model($this->data)->index();
			return view('index',[
				'data'  =>  $this->data,
				'classify'  =>  $this->classify,
				'title' =>  '我的消息',
				'message'  =>  $message
			]);
		}catch (\Exception $e){
			$this->error( $e->getMessage() );
		}
	}

	/**
	 * @return mixed|\think\response\Json
	 * @throws \Exception
	 * 消息列表
	 */
	public function messageList(){
		try{
			if (Request::isGet()){
				$messageLIst = $this->model($this->data)->messageList();
				return $messageLIst;
			}
		}catch (\Exception $e){
			return OutMsg::outAbnormalMsg( $e->getMessage() );
		}
	}

	public function AgreeFriend(){
		try{
			if (Request::isGet()){
				$data = input('get.');
				$Message = $this->model($this->data)->AgreeFriend($data);
				return $Message;
			}
		}catch (\Exception $e){
			return OutMsg::outAbnormalMsg( $e->getMessage() );
		}
	}


}