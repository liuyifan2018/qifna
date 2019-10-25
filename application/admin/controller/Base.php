<?php

namespace app\admin\controller;

use app\admin\interfaces\Service;

class Base implements Service {



	public function __construct() {

	}

	/************************* 必须实现的接口 ****************************/

	public function getSingleInfo() {
		// TODO: Implement getSingleInfo() method.
	}

	public function lUpdate() {
		// TODO: Implement lUpdate() method.
	}

	public function lInsert() {
		// TODO: Implement lInsert() method.
	}

	public function lDelete() {
		// TODO: Implement lDelete() method.
	}

	public function setStatus($data) {
		// TODO: Implement setStatus() method.
	}


}