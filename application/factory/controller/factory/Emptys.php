<?php
namespace app\factory\controller\factory;

use app\factory\Controller;

class Emptys extends Controller{

	public function index(){
		if ($this->stop == 1){
			return view('empty/stop');
		}
	}
}