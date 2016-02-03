<?php

// +----------------------------------------------------------------------
// | 李标
// +----------------------------------------------------------------------
// | 2015.7.7
// +----------------------------------------------------------------------
// | 用户关注商品或店铺模型
// +----------------------------------------------------------------------
class user_attention_model extends base_model {

	/**
	 * 关注商品添加
	 * @user_id   用户ID
	 * @data_id  数据ID
	 * @data_type  数据类型
	 * @return bool
	 */
	public function add($user_id, $data_id, $data_type) {
		if (!$user_id || !$data_id || !$data_type) {
			return false;
		}

		$data['user_id'] = $user_id;
		$data['data_id'] = $data_id;
		$data['data_type'] = $data_type;
		$data['add_time'] = time();
		$result = D('User_attention')->data($data)->add();
		if ($result) {
			if ($data_type == 1) {
				$result = D('Product')->where(array('product_id' => $data_id))->setInc('attention_num');
			} else {
				$result = D('Store')->where(array('store_id' => $data_id))->setInc('attention_num');
			}

			if ($result) {
				return true;
			} else {
				return false;
			}
		}
	}

	
	/**
	 * 取消关注功能  这功能并不做判断是否有关注
	 * param $uid
	 * param $id
	 * param $type
	 */
	public function cancel($uid, $id, $type) {
		if (!in_array($type, array(1, 2))) {
			return false;
		}
	
		$result = D('User_attention')->where(array('user_id' => $uid, 'data_id' => $id, 'data_type' => $type))->delete();
	
		if ($result) {
			if ($type == 1) {
				$result = D('Product')->where(array('product_id' => $id))->setInc('attention_num', -1);
			} else {
				$result = D('Store')->where(array('store_id' => $id))->setInc('attention_num', -1);
			}
							
			if ($result) {
				return true;
			} else {
				return false;
			}
		}
	
		return false;
	}	
}

?>
