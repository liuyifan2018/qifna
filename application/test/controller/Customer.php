<?php

namespace app\test\controller;

use app\test\interfaces\Shop;

class Customer {

	public function shopping(Shop $shop){
		$shop->sell();
	}
}