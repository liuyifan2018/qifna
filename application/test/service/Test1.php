<?php
namespace app\test\service;

use app\test\interfaces\Shop;

class Test1 implements Shop {

	public function sell() {
		echo 'test1';
	}
}