<?php

namespace app\widget\controller;

use Exception;

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
	 * widget搜索入口
	 * @author liuyifan
	 * @createTime 2019/10/15 14:11
	 */
	public function widgetQuery() {
		$postStr = file_get_contents("php://input");
		$this->setLog('返回数据',$postStr);
		try {
			if (!empty($postStr) && is_string($postStr)) {
				$postArr = json_decode($postStr, true);
				if ($postArr['MsgType'] == 'event' || $postArr['Event'] == 'wxa_widget_data') {    //widget事件消息
					$content['lifespan'] = 86400;
					$content['query'] = json_encode([
						"type"      => 1011045,
						"slot_list" => [
							[
								"value" => $postArr["Query"]
							],
							[
								"value" => $postArr["Query"]
							],
						]
					]);
					$content['scene'] = 1;
					$content['data'] = $this->keyword->keywords($postArr['Query'], 1);
					$jsonData = json_encode([
						"ToUserName"   => $postArr['ToUserName'],
						"FromUserName" => $postArr['FromUserName'],
						"CreateTime"   => time(),
						"MsgType"      => "widget_data",
						"Content"      => json_encode($content)
					]);
					$this->setLog('返回数据',$jsonData);
					exit($jsonData);
				}
			} else {
				echo '错误1';
			}
		} catch (Exception $e) {
			$this->setLog('返回数据',$e->getMessage());
		}
	}


	/** 错误日志
	 * @param $msg
	 * @param $data
	 */
	public function setLog($msg, $data) {
		$basePath = dirname(__File__);
		file_put_contents($basePath . '/fail.txt', $msg . '::::' . $data . '&&&&&&&&&&&', FILE_APPEND);
	}
}