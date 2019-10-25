<?php

namespace app\factory\data\factory;

use app\factory\data\Base;
use app\factory\MainFactory;

/**
 * 力量型工厂
 * Class A
 * @package app\factory\data\factory
 */
class C extends Base implements MainFactory
{

	/**
	 * @return mixed|void
	 */
	public function production() {
		$data = [
			'name'       => $this->name(),
			'type'       => $this->type(),
			'attack'     => $this->attack(),
			'blood'      => $this->blood(),
			'skil'       => $this->skill(),
			'is_del'     => 0,
			'status'     => 1,
			'experience' => 0,
			'date'       => time()
		];
		return $this->factory->factory($data);
	}

	/**
	 * @return string
	 */
	public function name() {
		return 'C';
	}

	/**
	 * @return string
	 */
	public function type() {
		return '力量型';
	}

	/**
	 * @return int
	 */
	public function attack() {
		return 50;
	}

	/**
	 * @return int
	 */
	public function blood() {
		return 50;
	}

	/**
	 * @return string
	 */
	public function skill() {
		return '';
	}

}