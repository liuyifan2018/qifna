<?php
namespace app\factory\interfaces\arms;

use app\factory\Shop;

/**
 * 武器 - 剑类
 * Interface Sword
 * @package app\factory\interfaces\arms
 */
interface Sword extends Shop {

	/**
	 * 铁剑
	 * @return mixed
	 */
	public function ironSword();

}