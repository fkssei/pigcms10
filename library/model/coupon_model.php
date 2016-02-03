<?php
/**
 * 优惠券model
 */
class coupon_model extends base_model{
	/**
	 * 获取某个优惠券
	 */
	public function getCoupon($where) {
		$coupon = $this->db->where($where)->find();
		return $coupon;
	}
	
	/**
	 * 根据id，返回有效的优惠券
	 */
	public function getValidCoupon($id) {
		$time = time();
		$where = array();
		$where['id'] = $id;
		$where['type'] = 2;
		$where['status'] = 1;
		$where['start_time'] = array('<=', $time);
		$where['end_time'] = array('>=', $time);
		$where['total_amount'] = array('>=', 'number');
		
		$coupon = $this->getCoupon($where);
		
		// 当赠送券有领取限制时进行处理
		if ($coupon['most_have'] != '0' && isset($_SESSION['user']) && !empty($_SESSION['user']['uid'])) {
			$where = array();
			$where['uid'] = $_SESSION['user']['uid'];
			$where['coupon_id'] = $coupon['id'];
			$where['delete_flg'] = 0;
			
			$user_coupon_count = M('User_coupon')->getCount($where);
			if ($user_coupon_count >= $coupon['most_have']) {
				return array();
			}
		}
		
		return $coupon;
	}
	
	/**
	 * 获取满足条件的优惠券记录数
	 */
	public function getCount($where) {
		$coupon_count = $this->db->field('count(1) as count')->where($where)->find();
		return $coupon_count['count'];
	}
	
	/**
	 * 根据条件获到优惠券列表
	 * 当limit与offset都为0时，表示不行限制
	 */
	public function getList($where, $order_by = '', $limit = 0, $offset = 0) {
		$this->db->where($where);
		if (!empty($order_by)) {
			$this->db->order($order_by);
		}

		if (!empty($limit)) {
			$this->db->limit($offset . ',' . $limit);
		}
		
		$coupon_list = $this->db->select();
		//echo $this->db->last_sql;
		return $coupon_list;
	}
	
	/**
	 * 根据产品ID获得优惠券
	 * $product_id_arr 产品ID数组
	 * $store_id 店铺ID
	 * $uid 店铺UID
	 */
	public function getListByProductId($product_id_arr, $store_id, $uid) {
		$time = time();
		$db_prefix = option('system.DB_PREFIX');
		$sql = "SELECT distinct c.* FROM `" . $db_prefix . "coupon` AS c LEFT JOIN `" . $db_prefix . "coupon_to_product` AS cp ON `c`.`id` = `cp`.`coupon_id` WHERE `c`.`store_id` = '" . $store_id . "' AND (`c`.`is_all_product` = '0' or `cp`.`product_id` in (" . join(',', $product_id_arr) . ")) AND `c`.`uid` = '" . $uid . "' AND `c`.`status` = '1' AND `c`.`start_time` <= '" . $time . "' AND `c`.`end_time` >= '" . $time . "'";
		$coupon_list = $this->db->query($sql);
		
		foreach ($coupon_list as &$coupon) {
			$where = array();
			$where['coupon_id'] = $coupon['id'];
				
			// 优惠参加产品
			if ($reward['is_all_product'] == '1') {
				$coupon_product_list = M('Coupon_to_product')->getList($where);
				$product_id_arr = array();
				foreach ($coupon_product_list as $tmp) {
					$product_id_arr[$tmp['product_id']] = $tmp['product_id'];
				}
	
				$coupon['product_list'] = $product_id_arr;
			} else {
				$coupon['product_list'] = 'ALL';
			}
		}

		return $coupon_list;
	}
	
	/**
	 * 更改优惠券,条件一般指的是ID
	 */
	public function save($data, $where) {
		$this->db->data($data)->where($where)->save();
	}
	
	/**
	 * 删除
	 */
	public function delete($where) {
		$this->db->where($where)->delete();
	}
}