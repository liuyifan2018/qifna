<?php

namespace app\energy\traits;

use app\energy\common\OutMsg;

trait GetParam
{
	/**
	 * @return array|mixed|string|null
	 * @throws \Exception
	 */
	public static function HandleParameters() {
		if ($_SERVER['REQUEST_METHOD']) {
			$data = input('param.');
			if (empty($data)) return null;
			if (is_array($data)) {
				foreach ($data as $k => $v) {
					$data[$k] = trim($v);
				}
			} else {
				$data = trim($data);
			}
			return $data;
		} else {
			return OutMsg::outAbnormalMsg("请求错误!");
		}

	}
}