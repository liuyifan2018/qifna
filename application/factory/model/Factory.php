<?php

namespace app\factory\model;

use think\Model;

/**
 * 生产工厂模型
 * Class Factory
 * @package app\factory\model
 */
class Factory extends Model
{

	/**
	 * 表名
	 * @var string
	 */
	public $name = 'factory';

	/**
	 * 生成方法
	 * @param $data
	 * @return bool
	 */
	public function factory($data) {
		if (!empty($data)) {
			if ($this->insert($data) === false) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
}