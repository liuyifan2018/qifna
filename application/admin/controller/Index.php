<?php
namespace app\admin\controller;

use app\admin\Controller;

class Index extends Controller{

	public function index(){
		return view('index',[
			'userInfo'	=>	$this->user
		]);
	}

	public function dataIndex(){
		return view('dataIndex',[
			'userInfo'	=>	$this->user
		]);
	}
}