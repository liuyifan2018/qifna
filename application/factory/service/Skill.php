<?php

namespace app\factory\service;

class Skill
{

	public $skills = ['A','B','C','D'];

	/**
	 * 获取技能
	 * @param $sid
	 * @return mixed
	 */
	public function getSkill($sid){
		for ($i = 0; $i < count($this->skills); $i++){
			if ($sid == $this->skills[$i]){
				return eval('$this->'.$this->skills[$i].'();');
			}
		}
	}

	public function A(){
		return '敬请期待...';
	}

	public function B(){
		return '敬请期待...';
	}

	public function C(){
		return '敬请期待...';
	}

	public function D(){
		return '敬请期待...';
	}
}