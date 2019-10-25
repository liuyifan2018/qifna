<?php
namespace app\factory\interfaces\arms;

use app\factory\Shop;

/**
 * 武器 - 弓类
 * Interface Arch
 * @package app\factory\interfaces\arms
 */
interface Arch extends Shop{

	public function arms();

	/**
	 * 木弓 不 这是神弓
	 * @return mixed
	 */
	public function woodenBow();
}