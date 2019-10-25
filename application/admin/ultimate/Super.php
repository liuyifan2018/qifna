<?php

namespace app\admin\ultimate;
/**
 * 终极方法
 * Class Super
 * @package app\admin\ultimate
 */
final class Super
{

	/**
	 * 获取文件夹内的所有文件名字
	 * @author liuyifan
	 * @createTime 2019/10/16 9:37
	 */
	public static function getDirName() {
		$arr = count(scandir('../application/forum/controller')) - 2;
		function filesinfo($path) {
			if (!is_dir($path)) return false;
			$files = scandir($path);
			static $count = -1;
			foreach ($files as $file) {
				if ($file == '.' || $file == '..') continue;
				$arr[] = iconv('gbk', 'utf-8', $file);
			}
			$count += 1;
			return $arr[$count];
		}

		for ($i = 0; $i < $arr; $i++) {
			echo filesinfo('../application/forum/controller') . '</br>';
		}
	}

	/**
	 * 获取当前文件名字
	 * @return bool|string
	 * @author liuyifan
	 * @createTime 2019/10/18 10:04
	 */
	public static function getFileName() {
		$php_self = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '/') + 1);
		return $php_self;
	}
}