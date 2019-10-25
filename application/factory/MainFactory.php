<?php
namespace app\factory;

/**
 * 生产主工厂
 * Interface MainFactory
 * @package app\factory
 */
interface MainFactory{

	/**
	 * 生产接口
	 * @return mixed
	 */
	public function production();
	
	public function name();

	public function type();

	public function attack();

	public function skill();

	public function blood();

}