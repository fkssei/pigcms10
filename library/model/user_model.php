<?php
class user_model extends base_model{
	/*添加用户*/
	public function add_user($user){
		if(!isset($user['phone'])) return array('err_code'=>1006,'err_msg'=>'必须携带手机号！');
		if(!isset($user['nickname'])) return array('err_code'=>1007,'err_msg'=>'必须携带用户名！');
		if(!isset($user['password'])) return array('err_code'=>1008,'err_msg'=>'必须携带密码！');
		if(!isset($user['check_phone'])) $user['check_phone']=0;
        if(!isset($user['openid'])) $user['openid'];

		$data_user['phone'] = $user['phone'];
		$data_user['nickname'] = $user['nickname'];
		$data_user['password'] = $user['password'];
		$data_user['check_phone'] = $user['check_phone'];
		$data_user['reg_time'] = $data_user['last_time'] = $_SERVER['REQUEST_TIME'];
		$data_user['reg_ip'] = $data_user['last_ip'] = ip2long($_SERVER['REMOTE_ADDR']);
        $data_user['avatar'] = $user['avatar'];
        $data_user['login_count'] = $user['login_count'];
        $data_user['openid'] = $user['openid'];
		if($uid = $this->db->data($data_user)->add()){
			$data_user['uid'] = $uid;
			return array('err_code'=>0,'err_msg'=>$data_user);
		}else{
			return array('err_code'=>1009,'err_msg'=>'用户添加失败！请重试。');
		}
	}
	/*得到用户*/
	public function get_user($field,$value){
		if(!in_array($field,array('uid','phone','nickname','openid'))) return array('err_code'=>-1,'err_msg'=>'field参数错误！');
		if(empty($value)) return array('err_code'=>-1,'err_msg'=>'value参数错误！');
		return array('err_code'=>0,'user'=>$this->db->where(array($field=>$value))->find());
	}
	/*保存用户信息*/
	public function save_user($condition,$data){
		return array('err_code'=>0,'err_msg'=>$this->db->where($condition)->data($data)->save());
	}
	/*手机号、union_id、open_id 直接登录入口*/
	public function autologin($field,$value){
		$condition_user[$field] = $value;
		$now_user = $this->db->where($condition_user)->find();
		if($now_user){
			if(empty($now_user['status'])){
				return array('err_code' => -1, 'err_msg' => '该帐号被禁止登录!');
			}
			$condition_save_user['uid'] = $now_user['uid'];
			$data_save_user['last_time'] = $_SERVER['REQUEST_TIME'];
			$data_save_user['last_ip'] = get_client_ip(1);
			$this->db->where($condition_save_user)->data($data_save_user)->save();

			return array('err_code' => 0, 'err_msg' => 'OK' ,'user'=>$now_user);
		}else{
			return array('err_code'=>1001,'err_msg'=>'没有此用户！');
		}
	}
    public function getUserById($uid)
    {
        $user = $this->db->where(array('uid' => $uid))->find();
        return $user;
    }

    //获取用户头像
    public function getAvatarById($uid)
    {
        $user = $this->db->field('avatar')->where(array('uid' => $uid))->find();
        return !empty($user['avatar']) ? $user['avatar'] : '';
    }

    //修改字段值
    public function setField($where, $data)
    {
        return $this->db->where($where)->data($data)->save();
    }

    //微信用户
    public function isWeixinFans($uid)
    {
        $user = $this->db->field('is_weixin')->where(array('uid' => $uid))->find();
        return !empty($user['is_weixin']) ? true : false;
    }

    //用户店铺数加1
    public function setStoreInc($uid)
    {
        return $this->db->where(array('uid' => $uid))->setInc('stores');
    }

    //用户店铺数减1
    public function setStoreDec($uid)
    {

        if($result = $this->db->where(array('uid' => $uid))->setDec('stores')) {
            $user = $this->db->field('stores')->where(array('uid' => $uid))->find();
            if (empty($user['stores'])) {
                $result = $this->db->where(array('uid' => $uid))->data(array('is_seller' => 0))->save();
            }
        }
        return $result;
    }

    //检测用户是否存在
    public function checkUser($where)
    {
        return $this->db->where($where)->find();
    }

    //添加新用户
    public function addUser($data)
    {
        return $this->db->data($data)->add();
    }

    //通过token获取开店用户
    public function getUserByToken($token) {
        $user = $this->db->where(array('token' => $token, 'is_seller' => 1))->find();
        return !empty($user['uid']) ? $user['uid'] : '';
    }

    public function getPaymentUrlByToken($token, $uid = '')
    {
        $where = array();
        $where['token'] = $token;
        if (!empty($uid)) {
            $where['uid'] = $uid;
        }
        $where['is_seller'] = 1;
        $user = $this->db->where($where)->find();
        return !empty($user['payment_url']) ? $user['payment_url'] : '';
    }

    public function getNotifyUrlByToken($token, $session_id = '', $third_id = '')
    {
        $where = array();
        $where['token'] = $token;
        if (!empty($session_id)) {
            $where['session_id'] = $session_id;
        }
        if (!empty($third_id)) {
            $where['third_id'] = $third_id;
        }
        $where['is_seller'] = 1;
        $user = $this->db->where($where)->find();
        return !empty($user['notify_url']) ? $user['notify_url'] : '';
    }

    //设置卖家
    public function setSeller($uid, $status)
    {
        return $this->db->where(array('uid' => $uid))->data(array('is_seller' => $status))->save();
    }

    //获取店铺粉丝数量
    public function getFansCount($where)
    {
        $sql = "SELECT COUNT(uid) AS count FROM " . option('system.DB_PREFIX') . 'user u';
        $_string = '';
        if (array_key_exists('_string', $where)) {
            $_string = ' AND ' . $where['_string'];
            unset($where['_string']);
        }
        $condition = array();
        foreach ($where as $key => $value) {
            $condition[] = $key . " = '" . $value . "'";
        }
        $where = ' WHERE ' . implode(' AND ', $condition) . $_string;
        $sql .= $where;
        $fans = $this->db->query($sql);
        if (!empty($fans)) {
            return !empty($fans[0]['count']) ? $fans[0]['count'] : 0;
        } else {
            return 0;
        }
    }

    //
    public function getFans($where, $offset, $limit, $order = '')
    {
        //$sql = "SELECT u.uid,u.nickname,u.phone,(SELECT COUNT(order_id) FROM " . option('system.DB_PREFIX') . "order o WHERE u.uid = o.uid) AS order_count, (SELECT SUM(total) FROM " . option('system.DB_PREFIX') . "order o WHERE u.uid = o.uid) AS order_total FROM " . option('system.DB_PREFIX') . "user u";
        $sql = "SELECT u.uid,u.nickname,u.phone,(SELECT COUNT(fx_order_id) FROM " . option('system.DB_PREFIX') . "fx_order fo1 WHERE fo1.uid = u.uid AND fo1.store_id = '" . $_SESSION['wap_drp_store']['store_id'] . "') AS order_count, (SELECT SUM(total) FROM " . option('system.DB_PREFIX') . "fx_order fo2  WHERE fo2.uid = u.uid AND fo2.store_id = '" . $_SESSION['wap_drp_store']['store_id'] . "') AS order_total FROM " . option('system.DB_PREFIX') . "user u";
        $_string = '';
        if (array_key_exists('_string', $where)) {
            $_string = ' AND ' . $where['_string'];
            unset($where['_string']);
        }
        $condition = array();
        foreach ($where as $key => $value) {
            $condition[] = $key . " = '" . $value . "'";
        }
        $where = ' WHERE ' . implode(' AND ', $condition) . $_string;
        $sql .= $where;
        if (empty($order)) {
            $order = 'u.uid DESC';
        }
        $order = ' ORDER BY ' . $order;
        $sql .= $order;
        $sql .= ' LIMIT ' . $offset . ',' . $limit;
        $fans = $this->db->query($sql);
        return $fans;
    }

	// 根据条件获取用户列表
	public function getList($where) {
		$user_list = $this->db->where($where)->select();

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
?>