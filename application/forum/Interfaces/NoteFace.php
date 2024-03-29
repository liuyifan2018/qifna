<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/6/21
 * Time: 16:21
 */
namespace app\forum\Interfaces;
interface NoteFace{
	/**
	 * @param $id
	 * @return mixed
	 * 帖子资料
	 */
	public function note( $id );

	/**
	 * @param $data
	 * @return mixed
	 * 修改帖子
	 */
	public function addNote( $data );

	/**
	 * @param $data
	 * @return mixed
	 * 编辑帖子
	 */
	public function editNote( $data );

	/**
	 * @param $id
	 * @return mixed
	 * 删除帖子
	 */
	public function delNote($id);

	/**
	 * @param $id
	 * @param $value
	 * @return mixed
	 * 终极方法
	 */
	public function superInfo( $id,$value );

	/**
	 * @param $n_id
	 * @return mixed
	 * 评论列表
	 */
	public function commentLists($n_id);

	/**
	 * @param $data
	 * @return mixed
	 * 评论
	 */
	public function content( $data );

	/**
	 * @param $data
	 * @return mixed
	 * 点赞
	 */
	public function good($data);

	/**
	 * @param $data
	 * @return mixed
	 * 举报
	 */
	public function report($data);

	/**
	 * @param $data
	 * @return mixed
	 * 收藏帖子
	 */
	public function collNote($data);

}