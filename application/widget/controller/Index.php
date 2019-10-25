<?php

namespace app\widget\controller;

use Exception;

include_once 'keywords.php';
/**
 * widget搜索入口
 * Class Index
 * @package app\widget\controller
 */
class Index
{

	/**
	 * 关键字模型
	 * @var Keywords
	 */
	public $keyword;

	public function __construct(Keywords $keyword) {
		$this->keyword = $keyword;
	}

	/**
	 * widget 保姆模板 搜索入口
	 * @author liuyifan
	 * @createTime 2019/10/15 14:11
	 */
	public function widgetNannyQuery() {
		try {
			$postStr = file_get_contents("php://input");
			if (!empty($postStr) && is_string($postStr)) {
				$postArr = json_decode($postStr, true);
				if ($postArr['MsgType'] == 'event' || $postArr['Event'] == 'wxa_widget_data') {    //widget事件消息
					$content['lifespan'] = 86400;
					$content['query'] = json_encode([
						"type"      => 1011045,
						"slot_list" => [
							[
								"key"   => "city",
								"value" => $postArr["Query"]
							],
							[
								"key"   => "service",
								"value" => $postArr["Query"]
							],
						]
					]);
					$content['scene'] = 1;
					$content['data'] = $this->keyword->keywords($postArr['Query'],1);
					$jsonData = json_encode([
						"ToUserName"   => $postArr['ToUserName'],
						"FromUserName" => $postArr['FromUserName'],
						"CreateTime"   => time(),
						"MsgType"      => "widget_data",
						"Content"      => json_encode($content)
					]);
					exit($jsonData);
				}
			} else {
				$this->keyword->base->getClass(1)->fixedData();
			}
		} catch (Exception $e) {
			$this->keyword->base->getClass(1)->fixedData();
		}
	}

	public function widgetElectricQuery(){

	}
}