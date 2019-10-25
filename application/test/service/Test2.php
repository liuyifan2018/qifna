<?php
namespace app\test\service;

use app\test\interfaces\Shop;

class Test2 implements Shop {

	public function sell() {
		echo 'test2';
	}
}