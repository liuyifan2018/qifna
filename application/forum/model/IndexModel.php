<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/6/21
 * Time: 10:38
 */
namespace app\forum\model;
use app\forum\Interfaces\IndexFace;
use think\Model;
class IndexModel extends Model implements IndexFace {

	/**
	 * @var $data
	 * 用户信息
	 */
	protected $data;

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
	}

	public function index($classify)
	{
		// TODO: Implement index() method.
	}

	public function search($title)
	{
		// TODO: Implement search() method.
	}
}