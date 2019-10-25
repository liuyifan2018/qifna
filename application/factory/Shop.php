<?php
namespace app\factory;

interface Shop{

	/**
	 * 武器生产方法
	 * @return mixed
	 */
	public function arms();

	/**
	 * 装备生产方法
	 * @return mixed
	 */
	public function equipment();

}
