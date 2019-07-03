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
	 * @param $map
	 * @return mixed
	 * 分类
	 */
	public static function classify($map){
		$classify = Db::name('forum_classify')->where($map)->order('sort asc,id desc')->limit(7)->select();
		empty($classify) ? [] : $classify;
		return $classify;
	}

	/**
	 * @param $map
	 * @return mixed
	 * 最火帖子
	 */
	public static function hotNote($map){
		$hotNote = Db::name('forum_note')->where($map)->order('num desc,date desc')->limit(6)->select();
		empty($hotNote) ? [] : $hotNote;
		return $hotNote;
	}
}