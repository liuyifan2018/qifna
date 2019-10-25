<?php
namespace app\admin\interfaces;

interface Service extends BaseService {

	/**
	 * 获取单个信息
	 * @param $id
	 * @param $model
	 * @return mixed
	 */
	public function getSingleInfo($id,$model);

	/**
	 * 更新数据
	 * @param $data
	 * @return mixed
	 */
	public function lUpdate($data);

	/**
	 * 新增数据
	 * @param $data
	 * @return mixed
	 */
	public function lInsert($data);

	/**
	 * 更新状态
	 * @param $data
	 * @return mixed
	 */
	public function setStatus($data);

	/**
	 * 删除数据
	 * @param $id
	 * @return mixed
	 */
	public function lDelete($id);
}