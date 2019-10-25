<?php

namespace app\admin\service;

use app\admin\model\Set as SetModel;
use app\admin\service\user\interest\Reward;

class Set
{
	public $reward;

	public function __construct(Reward $reward) {
		$this->reward = $reward;
	}

	/**
	 * 封闭/解封 站点
	 * @return bool
	 * @throws \think\Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/10/24 17:17
	 */
	public function stop() {
		$is_stop = SetModel::where('id', '=', 1)->find();
		$is_stop == empty($is_stop) ? null : $is_stop['stop'] == '1' ? '0' : '1';
		if (is_null($is_stop)) throw new \Exception('配置信息未找到!');
		$update = SetModel::where('id', '=', 1)->update(['stop' => $is_stop['stop']]);
		if ($update === false) throw new \Exception('操作失败!');
		if ($is_stop['stop'] == 0){
			$this->reward->systemRewards();
		}
		return true;
	}
}