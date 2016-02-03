<?php
/**
 * 订单优惠券模型
 */
class order_coupon_model extends base_model{
	// 根据订单号查询订单使用的优惠券
	public function getByOrderId($order_id) {
		if (empty($order_id)) {
			return array();
		}
		
		$where = array();
		$where['order_id'] = $order_id;
		
		$order_reward = $this->db->where($where)->find();
		return $order_reward;
	}
}
?>