<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/6/21
 * Time: 10:39
 */
namespace app\forum\Traits;
use think\Db;

trait Note{

	/**
	 * @return mixed
	 * 分类数据
	 */
	public static function classify(){
		$classify = Db::name('forum_classify')->where(['is_show' => 1])->order('sort asc,id desc')->limit(7)->select();
		empty($classify) ? [] : $classify;
		return $classify;
	}
}