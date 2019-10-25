<?php

namespace app\factory\data\factory;

use app\factory\data\Base;
use app\factory\MainFactory;

/**
 * 敏捷型工厂
 * Class A
 * @package app\factory\data\factory
 */
class A extends Base implements MainFactory{
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
	 *
	 * @return string
	 */
	public function name() {
		return 'A';
	}

	/**
	 * @return string
	 */
	public function type() {
		return '敏捷型';
	}

	/**
	 * @return mixed
	 */
	public function attack() {
		return $this->characteristic->attack(2);
	}

	/**
	 * @return mixed
	 */
	public function blood() {
		return $this->characteristic->blood(1);
	}

	/**
	 * @return mixed
	 */
	public function skill() {
		return $this->characteristic->skill(0);
	}

}