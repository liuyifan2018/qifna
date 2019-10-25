<?php

namespace app\admin\model;

use app\admin\CURD;
use app\admin\Model;

class Classify extends Model
{

	protected $name = 'classify';

	/**
	 * 增加需字段
	 * @return array|mixed
	 * @author liuyifan
	 * @createTime 2019/9/29 15:17
	 */
	public static function processedData() {
		return $data = [
			'create_time' => time(),
			'is_del'      => 1,
			'status'      => 1,
			'c_id'        => 0,
			'classify'    => 1
		];
	}

	/**
	 * 新增或编辑
	 * @param $data
	 * @return Classify|bool|int|string
	 * @throws \Exception
	 * @author liuyifan
	 * @createTime 2019/9/30 10:22
	 */
	public function verification($data) {
		$setClassName = debug_backtrace();
		array_shift($setClassName);
		$className = $setClassName[0]['function'];

		if (empty($data['title']))
			throw new \Exception('分类名不能为空!');

		if (!CURD::nameRepeat('classify', 'title', $data['title'], null))
			throw new \Exception('标题名重复!');

		$data['sort'] = (int)$data['sort'];

		switch ($className) {
			case 'classifyAdd':
				$operation = $this->insert($data, true);
				break;
			case 'classifyEdit':
				$operation = $this->where('id', '=', $data['id'])->update($data);
				break;
			default:
				$operation = false;
				break;
		}
		return $operation;
	}

	/**
	 * 删除分类
	 * @param $id
	 * @return bool
	 * @author liuyifan
	 * @createTime 2019/10/11 10:41
	 */
	public static function classifyDel($id) {
		if (self::where('id', '=', $id)->delete() === true) return true;
		return false;
	}
}