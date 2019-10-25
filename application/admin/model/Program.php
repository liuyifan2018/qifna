<?php

namespace app\admin\model;

use app\admin\Model;

class Program extends Model{

	protected $name = 'program';

	/**
	 * 列表查询条件
	 * @var array
	 */
	protected static $where = [
		['status', '=', 1],
		['is_del', '=', 1]
	];

	public static function whereProgram(){
		return self::$where;
	}
}