<?php
/**
 * 满减/送model
 */
class reward_model extends base_model{
	/**
	 * 根据产品信息返回满减/送
	 * $product参数需包含product_id, uid, store_id
	 */
	public function getRewardByProduct($product) {
		if (empty($product) || empty($product['product_id']) || empty($product['uid']) || empty($product['store_id'])) {
			return '';
		}
		
		$time = time();
		$db_prefix = option('system.DB_PREFIX');
		$sql = "SELECT r.* FROM `" . $db_prefix . "reward` AS r LEFT JOIN `" . $db_prefix . "reward_product` AS rp ON `r`.`id` = `rp`.`rid` WHERE `r`.`store_id` = '" . $product['store_id'] . "' AND (`r`.`is_all` = 1 or `rp`.`product_id` = '" . $product['product_id'] . "') AND `r`.`uid` = '" . $product['uid'] . "' AND `r`.`status` = '1' AND `r`.`start_time` <= '" . $time . "' AND `r`.`end_time` >= '" . $time . "' LIMIT 1";
		$reward = $this->db->query($sql);
		
		
		if (empty($reward)) {
			return '';
		}
		
		$reward_condition = M('Reward_condition')->getRewardConditionByRid($reward[0]['id']);
		
		return $reward_condition;
	}
	
	/**
	 * 获取某个满减/送
	 */
	public function getReward($where) {
		$reward = $this->db->where($where)->find();
		return $reward;
	}
	
	/**
	 * 获取满足条件的满减/送记录数
	 */
	public function getCount($where) {
		$present_count = $this->db->field('count(1) as count')->where($where)->find();
		return $present_count['count'];
	}
	
	/**
	 * 根据条件获到满减/送列表
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
		
		$present_list = $this->db->select();
		
		return $present_list;
	}
	
	/**
	 * 根据产品ID获得优惠活动
	 * $product_id_arr 产品ID数组
	 * $store_id 店铺ID
	 * $uid 店铺UID
	 */
	public function getListByProductId($product_id_arr, $store_id, $uid) {
		$time = time();
		$db_prefix = option('system.DB_PREFIX');
		$sql = "SELECT distinct r.* FROM `" . $db_prefix . "reward` AS r LEFT JOIN `" . $db_prefix . "reward_product` AS rp ON `r`.`id` = `rp`.`rid` WHERE `r`.`store_id` = '" . $store_id . "' AND (`r`.`is_all` = 1 or `rp`.`product_id` in (" . join(',', $product_id_arr) . ")) AND `r`.`uid` = '" . $uid . "' AND `r`.`status` = '1' AND `r`.`start_time` <= '" . $time . "' AND `r`.`end_time` >= '" . $time . "'";
		$reward_list = $this->db->query($sql);
		
		foreach ($reward_list as &$reward) {
			$where = array();
			$where['rid'] = $reward['id'];
			
			// 优惠条件
			$reward_condition_list = M('Reward_condition')->getList($where, 0, 0, 'id desc');
			$reward['condition_list'] = $reward_condition_list;
			
			// 优惠参加产品
			if ($reward['is_all'] == 2) {
				$reward_product_list = M('Reward_product')->getList($where);
				$product_id_arr = array();
				foreach ($reward_product_list as $tmp) {
					$product_id_arr[$tmp['product_id']] = $tmp['product_id'];
				}
				
				$reward['product_list'] = $product_id_arr;
			} else {
				$reward['product_list'] = array();
			}
		}
		return $reward_list;
	}
	
	/**
	 * 更改满减/送,条件一般指的是ID
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