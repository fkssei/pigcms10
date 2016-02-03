<?php
/**
 * 订单满减送模型
 */
class order_reward_model extends base_model{
	// 根据订单号查询订单使用的满减送
	public function getByOrderId($order_id) {
		if (empty($order_id)) {
			return array();
		}
		
		$where = array();
		$where['order_id'] = $order_id;
		
		$order_reward_list = $this->db->where($where)->select();
		foreach ($order_reward_list as &$order_reward) {
			$order_reward['content'] = unserialize($order_reward['content']);
		}
		
		return $order_reward_list;
	}
}
?>