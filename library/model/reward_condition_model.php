<?php
/**
 * 满减/送优惠条件model
 */
class reward_condition_model extends base_model{
	/**
	 * 根据条件获到满减/送条件列表
	 * 当limit与offset都为0时，表示不行限制
	 */
	public function getList($where, $limit = 0, $offset = 0, $order = 'id asc') {
		$this->db->where($where);
		$this->db->order($order);
		
		if (!empty($limit)) {
			$this->db->limit($offset . ',' . $limit);
		}
		
		$reward_condition_list = $this->db->select();
		
		return $reward_condition_list;
	}
	
	/**
	 * 更改满减/送优惠条件,条件一般指的是ID
	 */
	public function save($data, $where) {
		$this->db->data($data)->where($where)->save();
	}
	
	/**
	 * 添加满减/送优惠条件
	 */
	public function add($data) {
		$this->db->data($data)->add();
	}
	
	/**
	 * 删除
	 */
	public function delete($where) {
		$this->db->where($where)->delete();
	}
	
	/**
	 * 根据rid返回优惠门槛信息
	 * 如果
	 */
	public function getRewardConditionByRid($rid) {
		if (empty($rid)) {
			return array();
		}
		
		$where = array();
		$where['rid'] = $rid;
		$reward_condition_list = $this->getList($where);
		$return_arr = array();;
		foreach ($reward_condition_list as $reward_condition) {
			if ($reward_condition['coupon']) {
				$reward_condition['coupon'] = M('Coupon')->getValidCoupon($reward_condition['coupon']);
			}
			
			if ($reward_condition['present']) {
				$reward_condition['present'] = M('Present')->getProductByPid($reward_condition['present']);
			}
			
			$return_arr[] = getRewardStr($reward_condition);
		}
		
		$return_str = join('; ', $return_arr);
		return $return_str;
	}
}