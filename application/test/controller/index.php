<?php
namespace app\test\controller;

use app\test\service\Test1;
use app\test\service\Test2;

class Index{

	public $customer;

	public $test1;

	public $test2;

	public function __construct(Customer $customer,Test1 $test1, Test2 $test2) {
		$this->customer = $customer;
		$this->test1 = $test1;
		$this->test2 = $test2;
	}

	public function index(){
		echo '调用了:'."<br/>";
		$this->customer->shopping($this->test1);
		$this->customer->shopping($this->test2);
	}
}