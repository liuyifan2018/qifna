<?php

namespace app\factory\service;

/**
 * 英雄池
 * Class Hero
 * @package app\factory\service
 */
class Hero
{

	/**
	 * 模拟数据
	 * @var array
	 */
	public $data
		= [
			'name'   => 'A|B|C|D|E|S|T',
			'type'   => '1,2,3,4',
			'skil'   => '|||||',
			'blood'  => '||||',
			'attack' => '||||||',
			'skil'   => '|||||',
		];

	/**
	 * 英雄类
	 * @var $base
	 */
	public $base;

	/**
	 * 实例化生产类
	 * Hero constructor.
	 * @param Base $base
	 */
	public function __construct(Base $base) {
		$this->base = $base;
	}

	/**
	 * 生产英雄
	 * @param $data
	 * @return mixed
	 */
	public function heroPool($data) {
		$name = is_array($data) == true ? $data['name'] : $data;
		$names = ['A', 'B', 'C', 'D', 'E', 'S', 'T'];
		for ($i = 0; $i < count($names); $i++) {
			if ($name == $names[$i]) {
				$class = $this->base->getClass($i);
				$factory = $class->production();
				return $factory;
			}
		}
	}

}