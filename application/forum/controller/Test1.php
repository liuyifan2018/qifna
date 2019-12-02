<?php
/**
 * All my injuries are my medals
 * @author <liuyifan@915458370.email>
 * @Date: 2019/11/23 10:43
 */

namespace app\forum\controller;

class Test1
{

	public function index() {
		$login = true;

		$name = intval($login) <=> intval(true);
		if ($name == -1){
			throw new \Exception('错误!');
		}else{

		}
		return view();
	}
}