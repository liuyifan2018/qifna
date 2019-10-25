<?php
namespace app\admin\interfaces;

interface Controller{

	/**
	 * 获取单个信息
	 * @return mixed
	 */
	public function getSingleInfo();

	/**
	 * 更新数据
	 * @return mixed
	 */
	public function lUpdate();

	/**
	 * 新增数据
	 * @return mixed
	 */
	public function lInsert();

	/**
	 * 更新状态
	 * @return mixed
	 */
	public function setStatus();

	/**
	 * 删除数据
	 * @return mixed
	 */
	public function lDelete();
}