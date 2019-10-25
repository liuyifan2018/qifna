<?php

namespace app\energy\model;

class ClassifyModel extends BaseModel{

	protected $name = 'classify';

	/**
	 * 获取分类列表
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/10/10 20:50
	 */
	public static function classifyList() {
		$where = [
			['status', '=', '1'],
			['is_del', '=', '1']
		];
		$classify = self::where($where)
			->order(['sort' => 'desc', 'id' => 'asc'])
			->field('id,title')
			->select();
		foreach ($classify as $k => $v) {
			$classify[$k]['selected'] = 'false';
		}
		return $classify == empty($classify) ? [] : $classify;
	}

	/**
	 * 获取单个分类信息
	 * @param $id
	 * @return array|\PDOStatement|string|\think\Model|null
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @author liuyifan
	 * @createTime 2019/10/10 21:48
	 */
	public static function classifyInfo($id){
		$where = [
			['id' , '=' , $id]
		];
		$info = self::where($where)->find();
		return $info == empty($info) ? [] : $info;
	}

}