<?php

/**
 * 用户数据模型
 * User: pigcms_21
 * Date: 2015/3/18
 * Time: 15:05
 */
class UserModel extends Model {

    //微信用户
    public function isWeixinFans($uid) {
        $user = $this->field('is_weixin')->where(array('uid' => $uid))->find();
        return !empty($user['is_weixin']) ? true : false;
    }

    /* 添加用户 */

    public function add_user($user) {
        if (!isset($user['phone']))
            return array('err_code' => 1006, 'err_msg' => '必须携带手机号！');
        if (!isset($user['nickname']))
            return array('err_code' => 1007, 'err_msg' => '必须携带用户名！');
        if (!isset($user['password']))
            return array('err_code' => 1008, 'err_msg' => '必须携带密码！');
        if (!isset($user['check_phone']))
            $user['check_phone'] = 0;

        $data_user['phone'] = $user['phone'];
        $data_user['nickname'] = $user['nickname'];
        $data_user['password'] = md5($user['password']);
        $data_user['check_phone'] = $user['check_phone'];
        $data_user['reg_time'] = $data_user['last_time'] = $_SERVER['REQUEST_TIME'];
        $data_user['reg_ip'] = $data_user['last_ip'] = ip2long($_SERVER['REMOTE_ADDR']);
        $data_user['admin_id'] = $user['admin_id'] ? $user['admin_id'] : $_SESSION['system']['id'];
        if ($uid = $this->data($data_user)->add()) {
            $data_user['uid'] = $uid;
            return array('err_code' => 0, 'err_msg' => $data_user);
        } else {
            echo $this->getLastSql();
            return array('err_code' => 1009, 'err_msg' => '用户添加失败！请重试。');
        }
    }
	
		// 根据条件获取用户列表
	public function getList($where) {
		$user_list = $this->where($where)->select();

		$return_user_list = array();
		foreach ($user_list as $tmp) {
			if ($tmp['avatar']) {
				$tmp['avatar'] = getAttachmentUrl($tmp['avatar']);
			} else {
				$tmp['avatar'] = getAttachmentUrl('images/touxiang.png', false);
			}

			$return_user_list[$tmp['uid']] = $tmp;
		}

		return $return_user_list;
	}

}

