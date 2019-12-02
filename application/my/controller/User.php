<?php
/**
 * All my injuries are my medals
 * @author <liuyifan@915458370.email>
 * @Date: 2019/11/28 14:15
 */

namespace app\my\controller;

use app\my\service\Data;
use think\Controller;
use app\my\logic\User as UserLogic;
use app\my\service\User as UserService;
use app\my\model\User as UserModel;

class User extends Controller
{

	/**
	 * @param Data $data
	 * @param UserModel $userModel
	 * @return \think\response\View
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function login(Data $data, UserModel $userModel) {
		if ($data->userInfo()) $this->redirect('Index/index');

		if ($this->request->isPost()) {
			try {
				$user = [
					'username' => $this->request->post('username/s'),
					'password' => $this->request->post('password/s')
				];
				//数据检测
				if (!UserLogic::login($user)) throw new \Exception('数据格式验证失败!');
				//安全验证
				if (!UserService::login($user)) throw new \Exception('数据安全验证失败!');
				//记录登录日志
				$userModel->loginLog($user, $this->request->ip());
				return json(['code' => 1, 'msg' => '登录成功!']);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
		}
		return view();
	}

}