<?php
/**
 * @author liuyifan
 * @createTime 2019/10/20 11:20 PM
 */

namespace app\widget\data;

use app\widget\template\Cleaning;
use app\widget\template\Dredge;
use app\widget\template\Electric;
use app\widget\template\Moving;
use app\widget\template\Nanny;
use app\widget\template\Repair;

/**
 * 模板实现类
 * Class Base
 * @package app\widget\data
 */
class Base
{

	/**
	 * @var $nanny
	 */
	public $classes;

	/**
	 * 模板实例化
	 * Base constructor.
	 * @param Cleaning $cleaning
	 * @param Nanny $nanny
	 * @param Dredge $dredge
	 * @param Electric $electric
	 * @param Repair $repair
	 * @param Moving $moving
	 */
	public function __construct(Cleaning $cleaning, Nanny $nanny, Dredge $dredge, Electric $electric, Repair $repair, Moving $moving) {
		$this->classes = [$cleaning, $nanny, $dredge, $electric, $repair, $moving];

	}

	/**
	 * 返回指定模板类
	 * @param $kid
	 * @return mixed
	 */
	public function getClass($kid) {
		return $this->classes[$kid];
	}


}