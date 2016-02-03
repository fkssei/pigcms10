<?php
/**
 * 赠品model
 */
class present_model extends base_model{
	/**
	 * 获取某个赠品
	 */
	public function getPresent($where) {
		$present = $this->db->where($where)->find();
		return $present;
	}
	
	/**
	 * 获取满足条件的赠品记录数
	 */
	public function getCount($where) {
		$present_count = $this->db->field('count(1) as count')->where($where)->find();
		return $present_count['count'];
	}
	
	/**
	 * 根据条件获到赠品列表
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
	 * 更改赠品,条件一般指的是ID
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
	
	/**
	 * 根据id返回赠品的产品列表
	 * 返回的是有效的赠品的产品列表
	 */
	public function getProductByPid($pid) {
		$time = time();
		$where = array();
		$where['id'] = $pid;
		$where['status'] = 1;
		$where['start_time'] = array('<=', $time);
		$where['end_time'] = array('>=', $time);
		
		$present = $this->getPresent($where);
		
		if (empty($present)) {
			return array();
		}
		
		$product_list = M('Present_product')->getProductListByPid($pid);
		return $product_list;
	}
}