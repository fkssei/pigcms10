<?php
/**
 * 账号
 * User: pigcms_21
 * Date: 2015/3/3
 * Time: 14:41
 */
class account_controller extends base_controller{
	public function load(){
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');
		switch($action){
			case 'personal_content':
				$this->_personal_content();
				break;
			case 'company_content':
				$this->_company_content();
				break;
			case 'password_content':
				$this->_password_content();
				break;
			default:
				break;
		}
		$this->display($action);
	}

	//个人资料
	public function personal(){
		if(IS_POST){
			$data = array();
			$data['nickname'] = isset($_POST['nickname']) ? trim($_POST['nickname']) : '';
			$data['avatar'] = isset($_POST['avatar']) ? trim($_POST['avatar']) : '';
			$data['intro'] = isset($_POST['intro']) ? trim($_POST['intro']) : '';

			M('User')->save_user(array('uid' => $this->user_session['uid']), $data);
            $_SESSION['user']['nickname'] = $data['nickname'];
			json_return(0, '设置成功');
		}else{
			if(empty($this->store_session)){
				$condition_store['uid'] = $this->user_session['uid'];
				$store = D('Store')->where($condition_store)->order('`store_id` DESC')->find();
				if($store){
					if(empty($store['logo'])) $store['logo'] = 'default_shop_2.jpg';
					$_SESSION['store'] = $store;
				}else{
					pigcms_tips('您需要先创建一个店铺',url('store:select'));
				}
			}
		}
		$this->display();
	}

	//个人资料详细
	private function _personal_content(){
		$user = M('User')->getUserById($this->user_session['uid']);
		$this->assign('user', $user);
	}

	//公司信息
	public function company(){
		if (IS_POST) {
			$company = M('Company');
			$data = array();
			$data['name']     = isset($_POST['name']) ? trim($_POST['name']) : '';
			$data['province'] = isset($_POST['province']) ? trim($_POST['province']) : '';
			$data['city']     = isset($_POST['city']) ? trim($_POST['city']) : '';
			$data['area']     = isset($_POST['area']) ? trim($_POST['area']) : '';
			$data['address']  = isset($_POST['address']) ? trim($_POST['address']) : '';

			$where = array();
			$where['uid'] = $this->user_session['uid'];
            $company_info = $company->get($where['uid']);
            if (!empty($company_info)) {
                $result = $company->edit($where, $data);
            } else {
                $data['uid'] = $this->user_session['uid'];
                $result = $company->create($data);
                if (!empty($result['err_code'])) {
                    $result = true;
                } else {
                    $result = false;
                }
            }
			if ($result) {
				json_return(0, '公司修改成功');
			} else {
				json_return(1001, '公司修改失败');
			}
		}

		$user = M('User');
		$avatar = $user->getAvatarById($this->user_session['uid']);

		$this->assign('avatar', $avatar);
		$this->display();
	}

	//公司信息设置
	private function _company_content(){
		$company = M('Company');

		$company = $company->getCompanyByUid($this->user_session['uid']);

		$this->assign('company', $company);
	}

	//密码
	public function password(){
		if (IS_POST) {
			$user = M('User');

			$old_password = isset($_POST['old_password']) ? trim($_POST['old_password']) : '';
			$new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';

			$user_info = $user->getUserById($this->user_session['uid']);
			if (empty($old_password) || empty($new_password) || $user_info['password'] != md5($old_password)) {
				json_return(1001, '修改失败');
			} else {
				if ($user->setField(array('uid' => $this->user_session['uid']), array('password' => md5($new_password)))) {
					unset($_SESSION['user']);
					session_destroy();
					json_return(0, '修改成功');
				} else {
					json_return(1001, '修改失败');
				}
			}
		}
		$this->display();
	}

	//密码修改
	private function _password_content(){

	}

	//密码检测
	public function check_password(){
		$user = M('User');

		$password = isset($_POST['password']) ? trim($_POST['password']) : '';

		if (!empty($password)) {
			$user = $user->getUserById($this->user_session['uid']);
			if ($user['password'] == md5($password)) {
				json_return(0, '密码正确');
			} else {
				json_return(1001, '密码有误');
			}
	   } else {
			json_return(1001, '密码有误');
		}
	}
}