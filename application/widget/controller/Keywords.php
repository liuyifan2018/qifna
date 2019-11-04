<?php
/**
 * 关键字池
 * @author liuyifan
 * @createTime 2019/10/20 11:22 PM
 */

namespace app\widget\controller;

use app\widget\data\Base;
use app\widget\template\Nanny;

class Keywords
{

	public $queryType
		= [
			1 => '保洁',
			2 => '保姆',
			3 => '疏通',
			4 => '家电',
			5 => '家具',
			6 => '搬家',
		];

	/**
	 * @var $nanny
	 */
	public $nanny;

	/**
	 * 模板基类
	 * @var $base
	 */
	public $base;

	/**
	 * Keywords constructor.
	 * @param Base $base
	 */
	public function __construct(Base $base) {
		$this->base = $base;
	}


	public function keywords($query,$kid) {
		$totalData = $this->base->getClass($kid)->widgetData($query);
		return (string)$totalData;
		//因实现多Api模式，关闭此功能 (如果我拿这个关键字还要再关键字池循环匹配一遍，还不如直接过来已知标识的关键字，直接去取数据);
//		$data = json_decode($this->liuyifan_curl_get_contents('http://wy.51daoteng.com/phpexcel/import.php'));
//		foreach ($data as $k => $v) {
//			for ($i = 0; $i < count($data[0]); $i++) {
//				if ($query == $v[$i] || strpos($v[$i], $query) !== false) {    //保姆
//					$classes = $this->base->getClass($i);
//					$totalData = $classes->widgetData($query);
//					return $totalData;
//				}
//			}
//		}
	}


	function liuyifan_curl_get_contents($url) {
		//    return file_get_contents($url);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		$r = curl_exec($ch);
		curl_close($ch);
		return $r;
	}
}