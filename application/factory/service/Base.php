<?php

namespace app\factory\service;

use app\factory\data\factory\A;
use app\factory\data\factory\B;
use app\factory\data\factory\C;

/**
 * 生产基类
 * Class Base
 * @package app\factory\service
 */
class Base{

	public $classes;

	/**
	 * Base constructor.
	 * @param A $a
	 * @param B $b
	 * @param C $c
	 */
	public function __construct(A $a, B $b, C $c) {
		$this->classes = [
			$a,
			$b,
			$c
		];
	}

	/**
	 * 获取生产类
	 * @param $fid
	 * @return mixed
	 */
	public function getClass($fid) {
		return $this->classes[$fid];
	}
}