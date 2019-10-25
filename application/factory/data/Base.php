<?php
namespace app\factory\data;

use app\factory\model\Factory;
use app\factory\service\Characteristic;

class Base {


	/**
	 * 生产模型
	 * @var $factory
	 */
	public $factory;

	/**
	 * 属性池
	 * @var $characteristic
	 */
	public $characteristic;

	/**
	 * 实例化装置类
	 * Base constructor.
	 * @param Factory $factory
	 * @param Characteristic $characteristic
	 */
	public function __construct(Factory $factory,Characteristic $characteristic) {
		$this->factory = $factory;
		$this->characteristic = $characteristic;
	}

}

