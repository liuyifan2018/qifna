<?php
/**
 * All my injuries are my medals
 * @author <liuyifan@915458370.email>
 * @Date: 2019/12/2 14:48
 */

namespace app\my\controller;

use app\my\service\Data;
use think\Controller;

class UCenter extends Controller{

	public $data;

	public function __construct(Data $data) {
		parent::initialize(); // TODO: Change the autogenerated stub
		$this->data = $data;
	}
}