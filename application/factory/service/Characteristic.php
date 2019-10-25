<?php

namespace app\factory\service;

/**
 * 属性池
 * Class Characteristic
 * @package app\factory\service
 */
class Characteristic
{
	public $skill;

	public function __construct(Skill $skill) {
		$this->skill = $skill;
	}

	/**
	 * @var array
	 */
	public $bloods = [50, 100, 150, 200, 300];

	/**
	 * @var array
	 */
	public $attack = [10, 15, 20, 25, 30, 40, 100];

	/**
	 * @var array
	 */
	public $skills = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];

	/**
	 * 攻击
	 * @param $aid
	 * @return mixed
	 */
	public function attack($aid) {
		$this->super($this->attack, $aid);
	}

	/**
	 * 血量
	 * @param $bid
	 * @return mixed
	 */
	public function blood($bid) {
		$this->super($this->bloods, $bid);
	}

	/**
	 * @param $sid
	 * @return mixed
	 */
	public function skill($sid) {
		$this->skill->getSkill($this->skill[$sid]);
	}

	/**
	 * 获取方法
	 * @param $Arr
	 * @param $id
	 * @return mixed
	 */
	public function super($Arr, $id) {
		for ($i = 0; $i < count($Arr); $i++) {
			if ($id == $i) return $Arr[$i];
		}
	}
}